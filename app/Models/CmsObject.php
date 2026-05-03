<?php

namespace App\Models;

use App\Interfaces\CmsObjectInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CmsObject implements CmsObjectInterface
{
    protected $dbTableName = '';
    protected $listName = 'Lista';
    protected $addNewItemButtonName = 'Dodaj nowy element';
    protected $editItemUrl = '';
    protected $listItems;

    public $sucessSaveInfoText = 'Dane zapisane pomyślnie';
    public $breadCrub1 = null;
    public $breadCrub2 = null;
    public $userId = null;
    protected $modelObject;

    public $allowExport = false;
    public $exportFormats = ['csv'];
    public $exportFileName = 'export';

    public $allowAddNewItem = true;
    public $allowDeleteOnList = true;
    public $allowEditOnList = true;

    public $useAutomaticTimestamps = false;
    public $timestampCreatedField = 'created_at';
    public $timestampUpdatedField = 'updated_at';

    function __construct()
    {
        $this->userId = Auth::id();
    }

    public function getTableName()
    {
        return $this->dbTableName;
    }

    public function getListItems()
    {
    }

    public function renderList($objectName, $request = [], $extraView = '')
    {
        $fullObjectUrl = "\\App\\Models\\" . $objectName;
        $this->modelObject = new $fullObjectUrl();

        $requestData = $this->normalizeRequestData($request);

        $headers = $this->getListHeaders();
        $filtersValues = $this->getFiltersValues($requestData);
        $filtersExist = $this->filtersExist();
        $areasByField = $this->getAreasByField();

        $this->listItems = $this->buildListQuery($requestData)
            ->orderBy('id', 'desc')
            ->get();

        $viewData = [
            'listName' => $this->listName,
            'addNewItemButtonName' => $this->addNewItemButtonName,
            'editItemUrl' => $this->editItemUrl,
            'listItems' => $this->listItems,
            'breadCrub1' => $this->breadCrub1,
            'headers' => $headers,
            'dbTableName' => $this->dbTableName,
            'objectName' => $objectName,
            'areas' => $this->areas,
            'areasByField' => $areasByField,
            'filtersExist' => $filtersExist,
            'filtersValues' => $filtersValues,
            'extraView' => $extraView,
            'showIdOnList' => $this->showIdOnList(),
            'exportEnabled' => $this->allowExport,
            'exportFormats' => $this->getAvailableExportFormats(),
            'allowAddNewItem' => $this->allowAddNewItem,
            'allowDeleteOnList' => $this->allowDeleteOnList,
            'allowEditOnList' => $this->allowEditOnList,
        ];

        if (isset($this->addHtmlToList)) {
            $viewData['extraView'] = view($this->addHtmlToList, $viewData);
        } else {
            $viewData['extraView'] = '';
        }

        return view('cms.list', $viewData);
    }

    public function renderEdit($id)
    {
        if ($id === 'new') {
            $id = '';
            $editItem = null;
        } else {
            $editItem = DB::connection('mysql-esklep')->select(
                'select * FROM ' . $this->dbTableName . ' WHERE id = ?',
                [$id]
            );

            if (count($editItem) === 0) {
                echo 'Acess danied!';
                die();
            }
        }

        $viewData = [
            'id' => $id,
            'areas' => $this->areas,
            'objectName' => $this->objectName,
            'editItem' => $editItem
        ];

        if (isset($this->addHtmlToEdit)) {
            $viewData['extraView'] = view($this->addHtmlToEdit, $viewData);
        } else {
            $viewData['extraView'] = '';
        }

        return view('cms.edit', $viewData);
    }

    public function saveData()
    {
    }

    public function getImageUploadPath(array $area): string
    {
        $path = $area['uploadPath'] ?? '/uploads/media/';
        return '/' . trim($path, '/') . '/';
    }

    public function getImageAllowedExtensions(array $area): array
    {
        return $area['allowedExtensions'] ?? ['jpg', 'jpeg', 'png', 'webp'];
    }

    public function getImageMaxSizeMb(array $area): int
    {
        return $area['maxSizeMb'] ?? 10;
    }

    protected function normalizeRequestData($request): array
    {
        if ($request instanceof Request) {
            return $request->all();
        }

        if (is_array($request)) {
            return $request;
        }

        return [];
    }

    protected function buildListQuery(array $requestData)
    {
        $selectFields = $this->getListSelectFields();

        $query = DB::connection('mysql-esklep')
            ->table($this->dbTableName)
            ->select($selectFields);

        $this->applyFiltersToQuery($query, $requestData);

        return $query;
    }

    protected function buildExportQuery(array $requestData)
    {
        $selectFields = [];

        foreach ($this->getExportFields() as $fieldConfig) {
            $selectFields[] = $fieldConfig['field'];
        }

        $query = DB::connection('mysql-esklep')
            ->table($this->dbTableName)
            ->select($selectFields);

        $this->applyFiltersToQuery($query, $requestData);

        return $query;
    }

    protected function applyFiltersToQuery($query, array $requestData): void
    {
        foreach ($this->areas as $area) {
            if (!isset($area['onFilter']) || !$area['onFilter']) {
                continue;
            }

            $field = $area['field'];

            if (!array_key_exists($field, $requestData)) {
                continue;
            }

            $searchValue = is_string($requestData[$field])
                ? trim($requestData[$field])
                : $requestData[$field];

            if ($searchValue === '' || $searchValue === null) {
                continue;
            }

            $type = $area['type'] ?? 'text';

            if ($type === 'select' || $type === 'number') {
                $query->where($field, '=', $searchValue);
            } else {
                $query->where($field, 'LIKE', '%' . $searchValue . '%');
            }
        }
    }

    protected function getListSelectFields(): array
    {
        $selectFields = ['id'];

        foreach ($this->areas as $area) {
            if (!isset($area['onList']) || !$area['onList']) {
                continue;
            }

            if (!isset($area['field']) || $area['field'] === 'id') {
                continue;
            }

            $selectFields[] = $area['field'];
        }

        return array_values(array_unique($selectFields));
    }

    public function getListHeaders(): array
    {
        $headers = [];

        foreach ($this->areas as $area) {
            if (isset($area['onList']) && $area['onList']) {
                $headers[] = $area['name'];
            }
        }

        return $headers;
    }

    public function getAreasByField(): array
    {
        $areasByField = [];

        foreach ($this->areas as $area) {
            if (isset($area['field'])) {
                $areasByField[$area['field']] = $area;
            }
        }

        return $areasByField;
    }

    public function filtersExist(): bool
    {
        foreach ($this->areas as $area) {
            if (isset($area['onFilter']) && $area['onFilter']) {
                return true;
            }
        }

        return false;
    }

    public function getFiltersValues(array $requestData): array
    {
        $filtersValues = [];

        foreach ($this->areas as $area) {
            if (!isset($area['onFilter']) || !$area['onFilter']) {
                continue;
            }

            $field = $area['field'];

            if (!array_key_exists($field, $requestData)) {
                continue;
            }

            $value = $requestData[$field];

            if ($value === '' || $value === null) {
                continue;
            }

            $filtersValues[$field] = $value;
        }

        return $filtersValues;
    }

    public function showIdOnList(): bool
    {
        foreach ($this->areas as $area) {
            if (
                isset($area['field'], $area['onList']) &&
                $area['field'] === 'id' &&
                $area['onList']
            ) {
                return true;
            }
        }

        return false;
    }

    public function getAvailableExportFormats(): array
    {
        return is_array($this->exportFormats) ? $this->exportFormats : [];
    }

    public function exportFormatAvailable(string $format): bool
    {
        return in_array(
            mb_strtolower($format),
            array_map('mb_strtolower', $this->getAvailableExportFormats())
        );
    }

    public function getExportFileName(): string
    {
        return $this->exportFileName ?: 'export';
    }

    public function getExportFields(): array
    {
        $fields = [
            'id' => [
                'field' => 'id',
                'name' => 'ID',
            ]
        ];

        foreach ($this->areas as $area) {
            if (!isset($area['field'])) {
                continue;
            }

            $fields[$area['field']] = [
                'field' => $area['field'],
                'name' => $area['name'] ?? $area['field'],
            ];
        }

        return array_values($fields);
    }

    public function getExportHeaders(): array
    {
        $headers = [];

        foreach ($this->getExportFields() as $field) {
            $headers[] = $field['name'];
        }

        return $headers;
    }

    public function getExportRows($request = []): array
    {
        $requestData = $this->normalizeRequestData($request);

        return $this->buildExportQuery($requestData)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($item) {
                return (array)$item;
            })
            ->toArray();
    }
}
