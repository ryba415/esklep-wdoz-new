<?php

namespace App\Models;

class AdminNewsletter extends CmsObject
{
    public $objectName = 'AdminNewsletter';
    public $dbTableName = 'newsletter';
    public $listName = 'Lista osób zapisanych do newslettera';
    public $editItemUrl = 'panel/newsletter/subscriber';
    public $addNewItemButtonName = 'Dodaj adres e-mail';
    public $sucessSaveInfoText = 'Dane subskrybenta zostały zapisane';

    public $breadCrub1 = [
        'url' => '/panel/newsletter/',
        'name' => 'newsletter'
    ];

    public $breadCrub2 = [
        'url' => '/panel/newsletter/subscriber-new',
        'name' => 'subskrybent'
    ];

    public $allowExport = true;
    public $exportFormats = ['csv'];
    public $exportFileName = 'newsletter';

    public $useAutomaticTimestamps = true;
    public $timestampCreatedField = 'created';
    public $timestampUpdatedField = 'updated';

    public $areas = [
        [
            'name' => 'ID',
            'type' => 'number',
            'field' => 'id',
            'editable' => false,
            'onList' => true,
            'onFilter' => false,
        ],
        [
            'name' => 'E-mail',
            'type' => 'text',
            'field' => 'email',
            'editable' => true,
            'onList' => true,
            'onFilter' => true,
            'validations' => [
                'require' => true,
                'email' => true,
                'maxLength' => 255,
                'unique' => [
                    'table' => 'newsletter',
                    'column' => 'email',
                    'ignoreCurrentId' => true,
                    'message' => 'Taki adres e-mail jest już dodany',
                ],
            ]
        ],
        [
            'name' => 'Data utworzenia',
            'type' => 'text',
            'field' => 'created',
            'editable' => false,
            'onList' => true,
            'onFilter' => false,
        ],
        [
            'name' => 'Data aktualizacji',
            'type' => 'text',
            'field' => 'updated',
            'editable' => false,
            'onList' => true,
            'onFilter' => false,
        ],
        [
            'name' => 'Zgoda marketingowa',
            'type' => 'select',
            'field' => 'is_agree',
            'editable' => true,
            'onList' => true,
            'onFilter' => true,
            'options' => [
                '1' => 'Tak',
                '0' => 'Nie',
            ],
            'validations' => [
                'require' => true,
                'in' => ['0', '1'],
            ]
        ],
    ];
}
