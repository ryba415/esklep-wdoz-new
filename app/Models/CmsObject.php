<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\CmsObjectInterface;
use Illuminate\Support\Facades\URL;
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

    function __construct() {
        $this->userId = Auth::id();
    }

    public function getTableName(){
        return $this->dbTableName;
    }

    public function getListItems(){

    }

    public function renderList($objectName, $request = [], $extraView = ''){
        $fullObjectUrl = "\App\Models" . "\\" . $objectName;
        $this->modelObject = new $fullObjectUrl();

        $request = $request->all();

        $selectString = 'id';
        $headers = [];
        foreach ($this->modelObject->areas as $area){
            if (isset($area['onList']) && $area['onList']){
                if ($selectString !== ''){
                    $selectString = $selectString . ',';
                }
                $selectString = $selectString . $area['field'];
                $headers[] = $area['name'];
            }
        }

        $filtersExist = false;
        $searchString = '';
        $filtersValues = [];
        foreach ($this->modelObject->areas as $area){
            if (isset($area['onFilter']) && $area['onFilter']){
                $filtersExist = true;
                if (isset($request[$area['field']])){
                    if ($searchString != ''){
                        $searchString = $searchString . ' AND ';
                    }
                    $searchValue = $request[$area['field']];
                    if ($searchValue != ''){
                        $filtersValues[$area['field']] = $searchValue;
                        $searchString = $searchString . ' ' .$area['field'] . " LIKE '%" . $searchValue . "%'";
                    }
                }
            }
        }
        if ($searchString != ''){
            $searchString = ' WHERE ' . $searchString;
        }

        $this->listItems = DB::connection('mysql-esklep')->select('select ' . $selectString
                        . ' FROM ' . $this->dbTableName . $searchString . ' ORDER BY id DESC'
                        . ' ', []);

        $areasByField = [];
        foreach ($this->modelObject->areas as $area) {
            $areasByField[$area['field']] = $area;
        }

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
            'extraView' => $extraView
        ];

        if (isset($this->addHtmlToList)){
            $viewData['extraView'] = view($this->addHtmlToList,$viewData);
        } else {
            $viewData['extraView'] = '';
        }
        return view('cms.list',$viewData);
    }

    public function renderEdit($id){
        if ($id === 'new'){
            $id = '';
            $editItem = null;
        } else {
            $editItem = DB::connection('mysql-esklep')->select('select * '
                . ' FROM ' . $this->dbTableName . ' '
                . ' WHERE id = ?', [$id]);

            if (count($editItem) === 0){
                echo 'Acess danied!';die();
            }
        }

        $viewData = [
            'id' => $id,
            'areas' => $this->areas,
            'objectName' => $this->objectName,
            'editItem' => $editItem
        ];
        //var_dump($this);
        if (isset($this->addHtmlToEdit)){
            $viewData['extraView'] = view($this->addHtmlToEdit,$viewData);
        } else {
            $viewData['extraView'] = '';
        }
        return view('cms.edit',$viewData);
    }

    public function saveData(){

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
}

