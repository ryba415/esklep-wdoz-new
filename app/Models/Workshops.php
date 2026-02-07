<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
//use App\Interfaces\CmsObjectInterface;
use App\Models\CmsObject;

class Workshops extends CmsObject
{
    public $objectName = 'Workshops';
    public $dbTableName = 'workshops';
    public $listName = 'Lista zdefiniowanych zabudów warsztatowych';
    public $editItemUrl = 'import-workshop';
    public $addNewItemButtonName = 'Importuj nową zabudowę';
    public $breadCrub1 = [
        'url' => '/workshops',
        'name' => 'zabudowy'
    ];
    public $breadCrub2 = [
        'url' => '/workshops/workout-new',
        'name' => 'zabudowa'
    ];
    
    public $areas = [
        0 => [
            'name' => 'Identyfikator zabudowy',
            'type' => 'varchar',
            'field' => 'name',
            'editable' => true,
            'onList' => true,
            'validations' => [
                'require' => true,
                'nimLength' => 2,
                'maxLength' => 399
            ]
        ],
        1 => [
            'name' => 'Data utworzenia',
            'type' => 'varchar',
            'field' => 'created_date',
            'editable' => true,
            'onList' => true,
        ],
        2 => [
            'name' => 'Opis',
            'type' => 'varchar',
            'field' => 'description',
            'editable' => true,
            'onList' => true,
            'validations' => [
                'maxLength' => 2200
            ]
        ],
    ];

}

