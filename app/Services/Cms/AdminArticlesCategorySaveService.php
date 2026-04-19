<?php

namespace App\Services\Cms;

use App\Models\AdminArticlesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminArticlesCategorySaveService
{
    public function save(Request $request, AdminArticlesCategory $modelObject): array
    {
        $status = true;
        $errors = [];
        $errorsAreas = [];
        $userUnloged = false;
        $sucessSaveInfoText = '';

        $postData = $request->all();
        $editElemId = $postData['id']['value'] ?? null;

        $userId = Auth::id();
        if ($userId == null) {
            return [
                'status' => false,
                'errors' => ['Sesja wygasła - użytkownik wylogowany'],
                'errorsAreas' => [],
                'editElemId' => $editElemId,
                'sucessSaveInfoText' => '',
                'userUnloged' => true
            ];
        }

        $db = DB::connection('mysql-esklep');
        $schema = $db->getSchemaBuilder();

        $currentEditItem = null;
        if (!empty($editElemId)) {
            $currentEditItem = $db->table($modelObject->dbTableName)
                ->where('id', $editElemId)
                ->first();

            if (!$currentEditItem) {
                return [
                    'status' => false,
                    'errors' => ['Nie znaleziono edytowanej kategorii'],
                    'errorsAreas' => [],
                    'editElemId' => $editElemId,
                    'sucessSaveInfoText' => '',
                    'userUnloged' => false
                ];
            }
        }

        $title = trim((string)$this->getPostedValue($postData, 'title'));
        $positionInput = trim((string)$this->getPostedValue($postData, 'position'));
        $seoUrlInput = trim((string)$this->getPostedValue($postData, 'seo_url'));

        if ($title === '') {
            $status = false;
            $errors[] = 'Pole: Nazwa kategorii nie może pozostać puste';
            $errorsAreas[] = 'title';
        } elseif (mb_strlen($title) < 2) {
            $status = false;
            $errors[] = 'Pole: Nazwa kategorii musi mieć minimalnie 2 znaki';
            $errorsAreas[] = 'title';
        } elseif (mb_strlen($title) > 255) {
            $status = false;
            $errors[] = 'Pole: Nazwa kategorii może mieć maksymalnie 255 znaków';
            $errorsAreas[] = 'title';
        }

        if ($positionInput === '') {
            $positionInput = '0';
        }

        if (!preg_match('/^-?[0-9]+$/', $positionInput)) {
            $status = false;
            $errors[] = 'Pole: Kolejność wyświetlania musi być liczbą całkowitą';
            $errorsAreas[] = 'position';
        }

        if (empty($editElemId) && $seoUrlInput === '') {
            $seoUrlInput = $title;
        }

        $seoUrl = $this->normalizeSeoUrl($seoUrlInput);

        if ($seoUrl === '') {
            $status = false;
            $errors[] = 'Pole: Adres URL nie może pozostać puste';
            $errorsAreas[] = 'seo_url';
        } elseif (mb_strlen($seoUrl) > 255) {
            $status = false;
            $errors[] = 'Pole: Adres URL może mieć maksymalnie 255 znaków';
            $errorsAreas[] = 'seo_url';
        } else {
            $seoUrl = $this->generateUniqueSeoUrl($seoUrl, $editElemId);
        }

        if (!$status) {
            return [
                'status' => false,
                'errors' => array_values(array_unique($errors)),
                'errorsAreas' => array_values(array_unique($errorsAreas)),
                'editElemId' => $editElemId,
                'sucessSaveInfoText' => '',
                'userUnloged' => $userUnloged
            ];
        }

        try {
            $db->beginTransaction();

            $updateTable = [
                'title' => $title,
                'position' => (int)$positionInput,
                'seo_url' => $seoUrl,
            ];

            if ($schema->hasColumn($modelObject->dbTableName, 'slug')) {
                $updateTable['slug'] = $seoUrl;
            }

            if (empty($editElemId)) {
                if ($schema->hasColumn($modelObject->dbTableName, 'color')) {
                    $updateTable['color'] = '';
                }

                $editElemId = $db->table($modelObject->dbTableName)->insertGetId($updateTable);

                if (!$editElemId) {
                    throw new \RuntimeException('Nie udało się utworzyć kategorii artykułu');
                }
            } else {
                $db->table($modelObject->dbTableName)
                    ->where('id', $editElemId)
                    ->update($updateTable);
            }

            $db->commit();

            $sucessSaveInfoText = $modelObject->sucessSaveInfoText;

            return [
                'status' => true,
                'errors' => [],
                'errorsAreas' => [],
                'editElemId' => $editElemId,
                'sucessSaveInfoText' => $sucessSaveInfoText,
                'userUnloged' => false
            ];
        } catch (Throwable $e) {
            $db->rollBack();

            Log::error('Błąd zapisu kategorii artykułu CMS', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'status' => false,
                'errors' => ['Wystąpił wewnętrzny błąd podczas próby zapisu kategorii artykułu'],
                'errorsAreas' => [],
                'editElemId' => $editElemId,
                'sucessSaveInfoText' => '',
                'userUnloged' => false
            ];
        }
    }

    private function getPostedValue(array $postData, string $field, $default = '')
    {
        if (!isset($postData[$field])) {
            return $default;
        }

        if (is_array($postData[$field]) && array_key_exists('value', $postData[$field])) {
            return $postData[$field]['value'];
        }

        return $postData[$field];
    }

    private function normalizeSeoUrl(?string $value): string
    {
        $value = trim((string)$value);

        if ($value === '') {
            return '';
        }

        $value = $this->replacePolishChars($value);
        $value = mb_strtolower($value);
        $value = preg_replace('/\s+/', '-', $value);
        $value = preg_replace('/[^a-z0-9\-_]/', '', $value);
        $value = preg_replace('/-+/', '-', $value);
        $value = preg_replace('/_+/', '_', $value);
        $value = trim($value, '-_');

        return $value;
    }

    private function replacePolishChars(string $value): string
    {
        $map = [
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n',
            'ó' => 'o', 'ś' => 's', 'ż' => 'z', 'ź' => 'z',
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'L', 'Ń' => 'N',
            'Ó' => 'O', 'Ś' => 'S', 'Ż' => 'Z', 'Ź' => 'Z',
        ];

        return strtr($value, $map);
    }

    private function generateUniqueSeoUrl(string $baseSeoUrl, $currentId = null): string
    {
        $db = DB::connection('mysql-esklep');
        $candidate = $baseSeoUrl;
        $counter = 2;

        while (true) {
            $query = $db->table('article_category')->where('seo_url', $candidate);

            if (!empty($currentId)) {
                $query->where('id', '!=', $currentId);
            }

            $exists = $query->exists();

            if (!$exists) {
                return $candidate;
            }

            $candidate = $baseSeoUrl . '-' . $counter;
            $counter++;
        }
    }
}
