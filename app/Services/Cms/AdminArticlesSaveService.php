<?php

namespace App\Services\Cms;

use App\Helpers\CmsImageHelper;
use App\Models\AdminArticles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class AdminArticlesSaveService
{
    protected CmsImageHelper $cmsImageHelper;

    public function __construct(CmsImageHelper $cmsImageHelper)
    {
        $this->cmsImageHelper = $cmsImageHelper;
    }

    public function save(Request $request, AdminArticles $modelObject): array
    {
        $status = true;
        $errors = [];
        $errorsAreas = [];
        $userUnloged = false;
        $sucessSaveInfoText = '';

        $postData = $request->all();
        $filesData = $request->file('cms_files', []);
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
        $currentEditItem = null;

        if (!empty($editElemId)) {
            $currentEditItem = $db->table($modelObject->dbTableName)
                ->where('id', $editElemId)
                ->first();

            if (!$currentEditItem) {
                return [
                    'status' => false,
                    'errors' => ['Nie znaleziono edytowanego artykułu'],
                    'errorsAreas' => [],
                    'editElemId' => $editElemId,
                    'sucessSaveInfoText' => '',
                    'userUnloged' => false
                ];
            }
        }

        $title = trim((string)$this->getPostedValue($postData, 'title'));
        $seoUrlInput = trim((string)$this->getPostedValue($postData, 'seo_url'));
        $seoTitle = trim((string)$this->getPostedValue($postData, 'seo_title'));
        $seoDescription = trim((string)$this->getPostedValue($postData, 'seo_description'));
        $lead = (string)$this->getPostedValue($postData, 'lead');
        $content = (string)$this->getPostedValue($postData, 'content');
        $publishDateInput = trim((string)$this->getPostedValue($postData, 'publish_date'));
        $positionInput = trim((string)$this->getPostedValue($postData, 'position'));
        $articleCategoryId = trim((string)$this->getPostedValue($postData, 'article_category_id'));
        $isActive = trim((string)$this->getPostedValue($postData, 'isActive'));

        $articleProducts = $this->normalizeIds($request->input('article_products', []));

        foreach ($modelObject->areas as $area) {
            if (
                isset($area['editable']) && $area['editable'] &&
                isset($area['type']) && $area['type'] === 'image'
            ) {
                $result = $this->cmsImageHelper->validateArea(
                    $area,
                    (bool)($area['validations']['require'] ?? false),
                    $currentEditItem,
                    $request,
                    $filesData,
                    $modelObject
                );

                $this->applyHelperResult($result, $status, $errors, $errorsAreas);
            }
        }

        if ($title === '') {
            $status = false;
            $errors[] = 'Pole: Tytuł nie może pozostać puste';
            $errorsAreas[] = 'title';
        } elseif (mb_strlen($title) < 2) {
            $status = false;
            $errors[] = 'Pole: Tytuł musi mieć minimalnie 2 znaki';
            $errorsAreas[] = 'title';
        } elseif (mb_strlen($title) > 255) {
            $status = false;
            $errors[] = 'Pole: Tytuł może mieć maksymalnie 255 znaków';
            $errorsAreas[] = 'title';
        }

        if ($seoTitle !== '' && mb_strlen($seoTitle) > 255) {
            $status = false;
            $errors[] = 'Pole: SEO title może mieć maksymalnie 255 znaków';
            $errorsAreas[] = 'seo_title';
        }

        if ($seoDescription !== '' && mb_strlen($seoDescription) > 255) {
            $status = false;
            $errors[] = 'Pole: SEO description może mieć maksymalnie 255 znaków';
            $errorsAreas[] = 'seo_description';
        }

        if (empty($editElemId) && $seoUrlInput === '') {
            $seoUrlInput = $title;
        }

        $seoUrl = Str::slug($seoUrlInput, '-');

        if ($seoUrl === '') {
            $status = false;
            $errors[] = 'Pole: Adres URL nie może pozostać puste';
            $errorsAreas[] = 'seo_url';
        } else {
            $seoUrl = $this->generateUniqueSeoUrl($seoUrl, $editElemId);
        }

        if ($publishDateInput === '') {
            $status = false;
            $errors[] = 'Pole: Data publikacji nie może pozostać puste';
            $errorsAreas[] = 'publish_date';
        }

        $publishDate = $this->normalizeDate($publishDateInput);
        if ($publishDateInput !== '' && $publishDate === null) {
            $status = false;
            $errors[] = 'Pole: Data publikacji ma nieprawidłowy format';
            $errorsAreas[] = 'publish_date';
        }

        if ($positionInput === '') {
            $positionInput = '0';
        }

        if (!preg_match('/^-?[0-9]+$/', $positionInput)) {
            $status = false;
            $errors[] = 'Pole: Kolejność wyświetlania musi być liczbą całkowitą';
            $errorsAreas[] = 'position';
        }

        if ($articleCategoryId === '') {
            $status = false;
            $errors[] = 'Pole: Kategoria nie może pozostać puste';
            $errorsAreas[] = 'article_category_id';
        } elseif (!ctype_digit($articleCategoryId)) {
            $status = false;
            $errors[] = 'Pole: Kategoria ma nieprawidłową wartość';
            $errorsAreas[] = 'article_category_id';
        } else {
            $categoryExists = $db->table('article_category')
                ->where('id', (int)$articleCategoryId)
                ->exists();

            if (!$categoryExists) {
                $status = false;
                $errors[] = 'Wybrana kategoria nie istnieje';
                $errorsAreas[] = 'article_category_id';
            }
        }

        if ($isActive !== '0' && $isActive !== '1') {
            $status = false;
            $errors[] = 'Pole: Czy aktywny musi mieć wartość Tak lub Nie';
            $errorsAreas[] = 'isActive';
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

            $now = now()->format('Y-m-d H:i:s');

            $updateTable = [
                'title' => $title,
                'lead' => $lead,
                'content' => $content,
                'seo_url' => $seoUrl,
                'seo_title' => $seoTitle !== '' ? $seoTitle : null,
                'seo_description' => $seoDescription !== '' ? $seoDescription : null,
                'isActive' => (int)$isActive,
                'position' => (int)$positionInput,
                'slug' => $seoUrl,
                'article_category_id' => (int)$articleCategoryId,
                'publish_date' => $publishDate,
                'updated_at' => $now,
            ];

            if (empty($editElemId)) {
                $updateTable['created_at'] = $now;

                $editElemId = $db->table($modelObject->dbTableName)->insertGetId($updateTable);

                if (!$editElemId) {
                    throw new \RuntimeException('Nie udało się utworzyć artykułu');
                }
            } else {
                $db->table($modelObject->dbTableName)
                    ->where('id', $editElemId)
                    ->update($updateTable);
            }

            $currentEditItem = $db->table($modelObject->dbTableName)
                ->where('id', $editElemId)
                ->first();

            foreach ($modelObject->areas as $modelArea) {
                if (
                    isset($modelArea['editable']) && $modelArea['editable'] &&
                    isset($modelArea['type']) && $modelArea['type'] === 'image'
                ) {
                    $imageResult = $this->cmsImageHelper->prepareFieldForSave(
                        $modelArea,
                        (int)$editElemId,
                        $currentEditItem,
                        $request,
                        $filesData,
                        $modelObject
                    );

                    $this->applyHelperResult($imageResult, $status, $errors, $errorsAreas);

                    if (!$status) {
                        throw new \RuntimeException('Błąd podczas zapisu obrazka');
                    }

                    if (($imageResult['shouldUpdate'] ?? false) === true) {
                        $db->table($modelObject->dbTableName)
                            ->where('id', $editElemId)
                            ->update([
                                $modelArea['field'] => $imageResult['value'],
                                'updated_at' => now()->format('Y-m-d H:i:s')
                            ]);
                    }
                }
            }

            $validProductIds = [];
            if (!empty($articleProducts)) {
                $validProductIds = $db->table('ecommerce_products')
                    ->whereIn('id', $articleProducts)
                    ->pluck('id')
                    ->map(function ($id) {
                        return (int)$id;
                    })
                    ->toArray();
            }

            $db->table('article_products')
                ->where('article_id', $editElemId)
                ->delete();

            if (!empty($validProductIds)) {
                $insertProducts = [];

                foreach (array_values(array_unique($validProductIds)) as $productId) {
                    $insertProducts[] = [
                        'article_id' => (int)$editElemId,
                        'product_id' => (int)$productId,
                    ];
                }

                if (!empty($insertProducts)) {
                    $db->table('article_products')->insert($insertProducts);
                }
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

            Log::error('Błąd zapisu artykułu CMS', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'status' => false,
                'errors' => !empty($errors) ? array_values(array_unique($errors)) : ['Wystąpił wewnętrzny błąd podczas próby zapisu artykułu'],
                'errorsAreas' => array_values(array_unique($errorsAreas)),
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

    private function normalizeIds($values): array
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        $result = [];

        foreach ($values as $value) {
            if ($value === null || $value === '') {
                continue;
            }

            if (is_numeric($value)) {
                $result[] = (int)$value;
            }
        }

        return array_values(array_unique($result));
    }

    private function normalizeDate(?string $date): ?string
    {
        $date = trim((string)$date);

        if ($date === '') {
            return null;
        }

        $formats = [
            'Y-m-d',
            'd-m-Y',
            'd.m.Y',
            'd/m/Y',
        ];

        foreach ($formats as $format) {
            try {
                $carbon = Carbon::createFromFormat($format, $date);
                if ($carbon && $carbon->format($format) === $date) {
                    return $carbon->format('Y-m-d');
                }
            } catch (Throwable $e) {
            }
        }

        try {
            return Carbon::parse($date)->format('Y-m-d');
        } catch (Throwable $e) {
            return null;
        }
    }

    private function generateUniqueSeoUrl(string $baseSeoUrl, $currentId = null): string
    {
        $db = DB::connection('mysql-esklep');
        $candidate = $baseSeoUrl;
        $counter = 2;

        while (true) {
            $query = $db->table('article')->where('seo_url', $candidate);

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

    private function applyHelperResult(array $result, bool &$status, array &$errors, array &$errorsAreas): void
    {
        if (!($result['status'] ?? true)) {
            $status = false;
        }

        if (!empty($result['errors'])) {
            $errors = array_merge($errors, $result['errors']);
        }

        if (!empty($result['errorsAreas'])) {
            $errorsAreas = array_merge($errorsAreas, $result['errorsAreas']);
        }
    }
}
