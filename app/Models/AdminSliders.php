<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Cms\SaveData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
//use App\Interfaces\CmsObjectInterface;
use App\Models\CmsObject;

class AdminSliders extends CmsObject
{
    public $objectName = 'AdminSliders';
    public $dbTableName = 'slider';
    public $listName = 'Lista slajdów na stronie głównej';
    public $editItemUrl = 'admin/slides/slide';
    public $addNewItemButtonName = 'Stwórz slajd';
    public $breadCrub1 = [
        'url' => '/admin/slides/',
        'name' => 'sjalder na stronie głównej'
    ];
    public $breadCrub2 = [
        'url' => '/admin/slides/slide-new',
        'name' => 'slajd'
    ];
    
    
    public $areas = [
        0 => [
            'name' => 'Nazwa',
            'type' => 'select',
            'field' => 'title',
            'editable' => true,
            'onList' => true,
            'onFilter' => true,
            'validations' => [
                'require' => true,
                'nimLength' => 2,
                'maxLength' => 399
            ],
            'options' => [
                '' => '',
                'nazwa1' => 'nazwa 1',
                'nazwa2' => 'inna nazwa',
                'nazwa3' => 'nazwa 3',
                'nazwa4' => 'nnnn',
            ]
        ],
        1 => [
            'name' => 'Opis',
            'type' => 'text',
            'field' => 'description',
            'editable' => true,
            'onList' => true,
            'onFilter' => true,
            'validations' => [
                'require' => true,
                'nimLength' => 2,
                'maxLength' => 399
            ]
        ],
        
    ];

}


