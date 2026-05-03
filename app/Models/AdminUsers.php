<?php

namespace App\Models;

class AdminUsers extends AdminUserAccountsBase
{
    protected string $accountManagerType = 'user';

    public $objectName = 'AdminUsers';
    public $listName = 'Lista użytkowników';
    public $editItemUrl = 'panel/users/user';
    public $addNewItemButtonName = 'Dodaj użytkownika';
    public $sucessSaveInfoText = 'Dane użytkownika zostały zapisane';

    public $breadCrub1 = [
        'url' => '/panel/users/',
        'name' => 'użytkownicy'
    ];

    public $breadCrub2 = [
        'url' => '/panel/users/user-new',
        'name' => 'użytkownik'
    ];
}
