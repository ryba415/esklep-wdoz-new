<?php

namespace App\Models;

class AdminSliders extends CmsObject
{
    public $objectName = 'AdminSliders';
    public $dbTableName = 'slider';
    public $listName = 'Lista slajdów na stronie głównej';
    public $editItemUrl = 'panel/slides/slide';
    public $addNewItemButtonName = 'Stwórz slajd';
    public $breadCrub1 = [
        'url' => '/panel/slides/',
        'name' => 'sjalder na stronie głównej'
    ];
    public $breadCrub2 = [
        'url' => '/panel/slides/slide-new',
        'name' => 'slajd'
    ];

    public $areas = [

        0 => [
            'name' => 'Tytuł',
            'type' => 'text',
            'field' => 'title',
            'editable' => true,
            'onList' => true,
            'onFilter' => true,
            'validations' => [
                'require' => true,
                'nimLength' => 2,
                'maxLength' => 299
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
                'require' => false,
                'nimLength' => 2,
                'maxLength' => 599
            ]
        ],
        2 => [
            'name' => 'Link',
            'type' => 'text',
            'field' => 'url',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'validations' => [
                'require' => false,
                'nimLength' => 2,
                'maxLength' => 299
            ]
        ],

        3 => [
            'name' => 'Zdjęcie',
            'type' => 'image',
            'field' => 'img_name',
            'editable' => true,
            'onList' => true,
            'onFilter' => false,
            'multiple' => false,
            'uploadPath' => '/uploads/media/slider/',
            'allowedExtensions' => ['jpg', 'jpeg', 'png', 'webp'],
            'maxSizeMb' => 10,

            'validations' => [
                'require' => true,
            ],

            'info' => 'Dozwolone formaty: jpg, jpeg, png, webp'
        ],
    ];
}
