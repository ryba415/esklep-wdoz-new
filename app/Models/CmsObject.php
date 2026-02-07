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
    
    public function renderList($objectName){
        $fullObjectUrl = "\App\Models" . "\\" . $objectName;
        $this->modelObject = new $fullObjectUrl();
        
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
        
        $this->listItems = DB::select('select ' . $selectString
                        . ' FROM ' . $this->dbTableName . ' ORDER BY id DESC'
                        . ' ', []);
        
        $viewData = [
            'listName' => $this->listName,
            'addNewItemButtonName' => $this->addNewItemButtonName,
            'editItemUrl' => $this->editItemUrl,
            'listItems' => $this->listItems, 
            'breadCrub1' => $this->breadCrub1,
            'headers' => $headers,
        ];
        return view('cms.list',$viewData);
    }
    
    public function renderEdit($id){
        if ($id === 'new'){
            $id = '';
            $editItem = null;
        } else {
            $editItem = DB::select('select * '
                . ' FROM ' . $this->dbTableName . ' '
                . ' ', []);
            
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
        return view('cms.edit',$viewData);
    }
    
    public function saveData(){
        
    }
}

