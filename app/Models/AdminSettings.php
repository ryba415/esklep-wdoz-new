<?php

namespace App\Models;

class AdminSettings extends CmsObject
{
    public $objectName = 'AdminSettings';
    public $dbTableName = 'settings';
    public $listName = 'Ustawienia systemu';
    public $editItemUrl = 'panel/settings/setting';
    public $addNewItemButtonName = 'Dodaj ustawienie';

    public $sucessSaveInfoText = 'Ustawienie zostało zapisane';

    public $breadCrub1 = [
        'url' => '/panel/settings',
        'name' => 'ustawienia'
    ];

    public $breadCrub2 = [
        'url' => '/panel/settings/setting-new',
        'name' => 'ustawienie'
    ];

    public $allowAddNewItem = false;
    public $allowDeleteOnList = false;
    public $allowEditOnList = true;
    public $allowExport = false;

    public $areas = [
        [
            'name' => 'Kod',
            'type' => 'text',
            'field' => 'code',
            'editable' => true,
            'readonly' => true,
            'saveToMainTable' => false,
            'onList' => true,
            'onFilter' => false,
            'validations' => [
                'require' => false,
                'maxLength' => 200,
            ]
        ],
        [
            'name' => 'Etykieta',
            'type' => 'textarea',
            'field' => 'label',
            'editable' => true,
            'readonly' => true,
            'saveToMainTable' => false,
            'onList' => true,
            'onFilter' => false,
            'validations' => [
                'require' => false,
                'maxLength' => 500,
            ]
        ],
        [
            'name' => 'Wartość',
            'type' => 'text',
            'field' => 'value',
            'editable' => true,
            'onList' => true,
            'onFilter' => false,
            'validations' => [
                'require' => true,
                'maxLength' => 1200,
            ]
        ],
    ];
}
