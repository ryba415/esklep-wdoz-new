<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ListCrud;
use App\Http\Controllers\globalHelper\globalHelper;

class TableEdit extends Controller
{
    private $objectName = '';
    private $modelObject;


    public function __construct($objectName)
    {
        $this->objectName = $objectName;
        $fullObjectUrl = "\App\Models" . "\\" . $this->objectName;
        $this->modelObject = new $fullObjectUrl();
    }
    
    public function render($id){
        return $this->modelObject->renderEdit($id);
        
    }

}
