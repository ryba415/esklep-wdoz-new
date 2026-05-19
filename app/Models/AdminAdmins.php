<?php

namespace App\Models;

class AdminAdmins extends AdminUserAccountsBase
{
    protected string $accountManagerType = 'admin';

    public $objectName = 'AdminAdmins';
    public $listName = 'Lista administratorów';
    public $editItemUrl = 'panel/admins/admin';
    public $addNewItemButtonName = 'Dodaj administratora';
    public $sucessSaveInfoText = 'Dane administratora zostały zapisane';

    public $breadCrub1 = [
        'url' => '/panel/admins/',
        'name' => 'administratorzy'
    ];

    public $breadCrub2 = [
        'url' => '/panel/admins/admin-new',
        'name' => 'administrator'
    ];
}
