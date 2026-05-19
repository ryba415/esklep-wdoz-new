<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\CmsImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaveData extends Controller
{
    protected $modelsEnabledToSave = [
        'WorkoutDefinitions',
        'Workshops',
        'Users',
        'Orders',
        'AdminSliders',
        'AdminArticles',
        'AdminArticlesCategory',
        'AdminNewsletter',
        'AdminSettings',
        'AdminUsers',
        'AdminAdmins'
    ];

    protected $modelObject = null;
    protected $status = true;
    protected $errors = [];
    protected $errorsAreas = [];
    protected $postData = [];
    protected $filesData = [];
    protected $editElemId = null;
    protected $sucessSaveInfoText = '';
    protected $currentEditItem = null;
    protected $request = null;

    protected CmsImageHelper $cmsImageHelper;

    public function __construct(CmsImageHelper $cmsImageHelper)
    {
        $this->cmsImageHelper = $cmsImageHelper;
    }

    public function universalSave(Request $request, $objectName)
    {
        $userUnloged = false;

        if (in_array($objectName, $this->modelsEnabledToSave)) {

            $this->request = $request;
            $this->postData = $request->all();
            $this->filesData = $request->file('cms_files', []);
            $this->editElemId = $this->postData['id']['value'] ?? null;

            $fullObjectUrl = "\\App\\Models\\" . $objectName;
            $this->modelObject = new $fullObjectUrl();
            $userId = Auth::id();

            if ($userId != null) {
                if (is_object($this->modelObject)) {

                    if (!empty($this->editElemId)) {
                        $this->currentEditItem = DB::connection('mysql-esklep')
                            ->table($this->modelObject->dbTableName)
                            ->where('id', $this->editElemId)
                            ->first();
                    }

                    if (method_exists($this->modelObject, 'ownSaveAction')) {
                        return response()->json($this->modelObject->ownSaveAction($request, $this->postData));
                    }

                    $this->validateData();

                    if ($this->status) {
                        $updateTable = [];

                        foreach ($this->modelObject->areas as $modelArea) {
                            if (
                                isset($modelArea['editable']) && $modelArea['editable'] &&
                                (!isset($modelArea['type']) || $modelArea['type'] !== 'image') &&
                                (!isset($modelArea['saveToMainTable']) || $modelArea['saveToMainTable'] !== false)
                            ) {
                                $field = $modelArea['field'];

                                if (isset($this->postData[$field]) && isset($this->postData[$field]['value'])) {
                                    $updateTable[$field] = $this->postData[$field]['value'];
                                }
                            }
                        }

                        $this->applyAutomaticTimestamps($updateTable);

                        if ($this->editElemId == null || $this->editElemId == '') {
                            $saveStatus = DB::connection('mysql-esklep')
                                ->table($this->modelObject->dbTableName)
                                ->insert($updateTable);

                            $this->editElemId = DB::connection('mysql-esklep')->getPdo()->lastInsertId();

                            if ($saveStatus === 0) {
                                $this->status = false;
                                $this->errors[] = 'Wystąpił wewnętrzny błąd podczas próby zapisu';
                            }

                            if ($this->status) {
                                $this->currentEditItem = DB::connection('mysql-esklep')
                                    ->table($this->modelObject->dbTableName)
                                    ->where('id', $this->editElemId)
                                    ->first();
                            }
                        }

                        $imageUpdateTable = [];

                        if ($this->status) {
                            foreach ($this->modelObject->areas as $modelArea) {
                                if (
                                    isset($modelArea['editable']) && $modelArea['editable'] &&
                                    isset($modelArea['type']) && $modelArea['type'] === 'image'
                                ) {
                                    $imageResult = $this->cmsImageHelper->prepareFieldForSave(
                                        $modelArea,
                                        (int)$this->editElemId,
                                        $this->currentEditItem,
                                        $this->request,
                                        $this->filesData,
                                        $this->modelObject
                                    );

                                    $this->applyHelperResult($imageResult);

                                    if (!$this->status) {
                                        break;
                                    }

                                    if ($imageResult['shouldUpdate']) {
                                        $imageUpdateTable[$modelArea['field']] = $imageResult['value'];
                                    }
                                }
                            }
                        }

                        if ($this->status) {
                            $finalUpdateTable = array_merge($updateTable, $imageUpdateTable);

                            if (!empty($finalUpdateTable)) {
                                DB::connection('mysql-esklep')
                                    ->table($this->modelObject->dbTableName)
                                    ->where(['id' => $this->editElemId])
                                    ->update($finalUpdateTable);
                            }

                            $this->sucessSaveInfoText = $this->modelObject->sucessSaveInfoText;
                        }
                    }

                } else {
                    $this->errors[] = 'Błędny obiekt modelu';
                    $this->status = false;
                }
            } else {
                $userUnloged = true;
                $this->errors[] = 'Sesja wygasła - użytkownik wylogowany';
                $this->status = false;
            }
        } else {
            $this->errors[] = 'Brak uprawnień do zapisu tego obiektu';
            $this->status = false;
        }

        return response()->json([
            'status' => $this->status,
            'errors' => $this->errors,
            'errorsAreas' => $this->errorsAreas,
            'editElemId' => $this->editElemId,
            'sucessSaveInfoText' => $this->sucessSaveInfoText,
            'userUnloged' => $userUnloged
        ]);
    }

    private function validateData()
    {
        foreach ($this->modelObject->areas as $area) {
            if (!isset($area['editable']) || !$area['editable']) {
                continue;
            }

            $field = $area['field'];
            $fieldName = $area['name'];
            $validations = $area['validations'] ?? [];
            $isRequired = isset($validations['require']) ? (bool)$validations['require'] : false;

            if (isset($area['type']) && $area['type'] === 'image') {
                $result = $this->cmsImageHelper->validateArea(
                    $area,
                    $isRequired,
                    $this->currentEditItem,
                    $this->request,
                    $this->filesData,
                    $this->modelObject
                );

                $this->applyHelperResult($result);
                continue;
            }

            if ($isRequired) {
                $this->requireValidation($field, $fieldName);
            }

            if ($this->hasPostedValue($field)) {
                if (isset($validations['nimLength'])) {
                    $this->nimLengthValidation($field, $fieldName, $validations['nimLength']);
                }

                if (isset($validations['maxLength'])) {
                    $this->maxLengthValidation($field, $fieldName, $validations['maxLength']);
                }

                if (!empty($validations['email'])) {
                    $this->emailValidation($field, $fieldName);
                }

                if (isset($validations['unique'])) {
                    $this->uniqueValidation($field, $fieldName, $validations['unique']);
                }

                if (isset($validations['in'])) {
                    $this->inValidation($field, $fieldName, $validations['in']);
                }
            }
        }
    }

    private function applyHelperResult(array $result): void
    {
        if (!($result['status'] ?? true)) {
            $this->status = false;
        }

        if (!empty($result['errors'])) {
            $this->errors = array_merge($this->errors, $result['errors']);
        }

        if (!empty($result['errorsAreas'])) {
            $this->errorsAreas = array_values(array_unique(array_merge($this->errorsAreas, $result['errorsAreas'])));
        }
    }

    private function hasPostedValue($field): bool
    {
        return isset($this->postData[$field]) &&
            isset($this->postData[$field]['value']) &&
            trim((string)$this->postData[$field]['value']) !== '';
    }

    private function requireValidation($field, $fieldName, $showErrors = true)
    {
        if ($this->hasPostedValue($field)) {
            return true;
        }

        $this->status = false;

        if ($showErrors) {
            $this->errors[] = 'Pole: ' . $fieldName . ' nie może pozostać puste';
            $this->errorsAreas[] = $field;
        }

        return false;
    }

    private function nimLengthValidation($field, $fieldName, $restict, $showErrors = true)
    {
        if ($this->hasPostedValue($field)) {
            if (mb_strlen((string)$this->postData[$field]['value']) >= $restict) {
                return true;
            } else {
                $this->status = false;
                if ($showErrors) {
                    $this->errors[] = 'Pole: ' . $fieldName . ' musi mieć minimalnie ' . $restict . ' znaków';
                    $this->errorsAreas[] = $field;
                }
                return false;
            }
        }

        return true;
    }

    private function maxLengthValidation($field, $fieldName, $restict, $showErrors = true)
    {
        if ($this->hasPostedValue($field)) {
            if (mb_strlen((string)$this->postData[$field]['value']) <= $restict) {
                return true;
            } else {
                $this->status = false;
                if ($showErrors) {
                    $this->errors[] = 'Pole: ' . $fieldName . ' może mieć maksymalnie ' . $restict . ' znaków';
                    $this->errorsAreas[] = $field;
                }
                return false;
            }
        }

        return true;
    }

    private function emailValidation($field, $fieldName, $showErrors = true)
    {
        if (!$this->hasPostedValue($field)) {
            return true;
        }

        $value = trim((string)$this->postData[$field]['value']);

        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        $this->status = false;

        if ($showErrors) {
            $this->errors[] = 'Pole: ' . $fieldName . ' ma nieprawidłowy format';
            $this->errorsAreas[] = $field;
        }

        return false;
    }

    private function uniqueValidation($field, $fieldName, $config = true, $showErrors = true)
    {
        if (!$this->hasPostedValue($field)) {
            return true;
        }

        $table = $this->modelObject->dbTableName;
        $column = $field;
        $ignoreCurrentId = true;
        $message = 'Pole: ' . $fieldName . ' ma już przypisaną taką wartość';

        if (is_array($config)) {
            $table = $config['table'] ?? $table;
            $column = $config['column'] ?? $column;
            $ignoreCurrentId = $config['ignoreCurrentId'] ?? $ignoreCurrentId;
            $message = $config['message'] ?? $message;
        }

        $value = trim((string)$this->postData[$field]['value']);

        $query = DB::connection('mysql-esklep')
            ->table($table)
            ->where($column, $value);

        if ($ignoreCurrentId && !empty($this->editElemId)) {
            $query->where('id', '!=', $this->editElemId);
        }

        if (!$query->exists()) {
            return true;
        }

        $this->status = false;

        if ($showErrors) {
            $this->errors[] = $message;
            $this->errorsAreas[] = $field;
        }

        return false;
    }

    private function inValidation($field, $fieldName, $allowedValues = [], $showErrors = true)
    {
        if (!$this->hasPostedValue($field)) {
            return true;
        }

        $value = (string)$this->postData[$field]['value'];
        $allowedValues = array_map('strval', (array)$allowedValues);

        if (in_array($value, $allowedValues, true)) {
            return true;
        }

        $this->status = false;

        if ($showErrors) {
            $this->errors[] = 'Pole: ' . $fieldName . ' ma nieprawidłową wartość';
            $this->errorsAreas[] = $field;
        }

        return false;
    }

    private function applyAutomaticTimestamps(array &$updateTable): void
    {
        if (!($this->modelObject->useAutomaticTimestamps ?? false)) {
            return;
        }

        $now = now()->format('Y-m-d H:i:s');

        $updatedField = $this->modelObject->timestampUpdatedField ?? null;
        $createdField = $this->modelObject->timestampCreatedField ?? null;

        if (!empty($updatedField)) {
            $updateTable[$updatedField] = $now;
        }

        if (($this->editElemId == null || $this->editElemId == '') && !empty($createdField)) {
            $updateTable[$createdField] = $now;
        }
    }

    public function universalDeleteOnList($itemId, $objectName)
    {
        $status = false;

        if (in_array($objectName, $this->modelsEnabledToSave)) {
            $fullObjectUrl = "\\App\\Models\\" . $objectName;
            $modelObject = new $fullObjectUrl();

            $item = DB::connection('mysql-esklep')
                ->table($modelObject->dbTableName)
                ->where('id', $itemId)
                ->first();

            if ($item) {
                if (method_exists($modelObject, 'ownDeleteAction')) {
                    $deleteResult = $modelObject->ownDeleteAction($itemId);

                    if (is_array($deleteResult) && isset($deleteResult['status']) && !$deleteResult['status']) {
                        return response()->json($deleteResult);
                    }
                }

                foreach ($modelObject->areas as $area) {
                    if (isset($area['type']) && $area['type'] === 'image') {
                        $field = $area['field'];

                        if (isset($item->{$field}) && $item->{$field} != null && $item->{$field} != '') {
                            $this->cmsImageHelper->deleteImagesFromStoredValue($item->{$field});
                        }
                    }
                }
            }

            DB::connection('mysql-esklep')
                ->table($modelObject->dbTableName)
                ->where('id', $itemId)
                ->delete();

            $status = true;
        }

        return response()->json([
            'status' => $status,
        ]);
    }
}
