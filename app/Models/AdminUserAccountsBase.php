<?php

namespace App\Models;

use App\Services\Cms\AdminUserAccountDeleteService;
use App\Services\Cms\AdminUserAccountSaveService;
use App\Services\Cms\UserAccountRoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class AdminUserAccountsBase extends CmsObject
{
    public $dbTableName = 'fos_user';

    protected string $accountManagerType = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->areas = $this->buildAreas();
    }

    public function getAccountManagerType(): string
    {
        return $this->accountManagerType;
    }

    public function ownSaveAction(Request $request, $postData = [])
    {
        return app(AdminUserAccountSaveService::class)->save($request, $this);
    }

    public function ownDeleteAction($itemId)
    {
        return app(AdminUserAccountDeleteService::class)->delete((int)$itemId, $this);
    }

    public function renderList($objectName, $request = [], $extraView = '')
    {
        $requestData = $this->normalizeRequestData($request);

        $headers = $this->getListHeaders();
        $filtersValues = $this->getFiltersValues($requestData);
        $filtersExist = $this->filtersExist();
        $areasByField = $this->getAreasByField();

        $query = DB::connection('mysql-esklep')
            ->table($this->dbTableName)
            ->select($this->getListSelectFields());

        app(UserAccountRoleService::class)->applyAccountTypeScope($query, $this->accountManagerType);

        $this->applyFiltersToQuery($query, $requestData);

        $this->listItems = $query
            ->orderBy('id', 'desc')
            ->get();

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
            'extraView' => '',
            'showIdOnList' => $this->showIdOnList(),
            'exportEnabled' => false,
            'exportFormats' => [],
            'allowAddNewItem' => true,
            'allowDeleteOnList' => true,
            'allowEditOnList' => true,
        ];

        return view('cms.list', $viewData);
    }

    public function renderEdit($id)
    {
        if ($id === 'new') {
            $id = '';
            $editItem = [$this->buildEmptyEditItem()];
        } else {
            $user = DB::connection('mysql-esklep')
                ->table('fos_user')
                ->where('id', $id)
                ->first();

            if (!$user) {
                echo 'Acess danied!';
                die();
            }

            $shippingAddress = null;
            if (!empty($user->shipping_address_id)) {
                $shippingAddress = DB::connection('mysql-esklep')
                    ->table('fos_user_shipping_address')
                    ->where('id', $user->shipping_address_id)
                    ->first();
            }

            $editItem = [$this->buildMergedEditItem($user, $shippingAddress)];
        }

        $viewData = [
            'id' => $id,
            'areas' => $this->areas,
            'objectName' => $this->objectName,
            'editItem' => $editItem,
            'extraView' => ''
        ];

        return view('cms.edit', $viewData);
    }

    protected function buildEmptyEditItem(): \stdClass
    {
        $item = new \stdClass();

        $item->username = '';
        $item->email = '';
        $item->enabled = '1';
        $item->first_name = '';
        $item->last_name = '';
        $item->street = '';
        $item->city = '';
        $item->postal_code = '';
        $item->province = '';
        $item->account_type = $this->accountManagerType;

        $item->shipping_firstName = '';
        $item->shipping_lastName = '';
        $item->shipping_street = '';
        $item->shipping_house_number = '';
        $item->shipping_city = '';
        $item->shipping_zipCode = '';
        $item->shipping_phoneNumber = '';
        $item->shipping_company = '';
        $item->shipping_state = '';

        return $item;
    }

    protected function buildMergedEditItem(object $user, ?object $shippingAddress = null): \stdClass
    {
        $item = new \stdClass();

        $item->username = $user->username ?? '';
        $item->email = $user->email ?? '';
        $item->enabled = (string)($user->enabled ?? '1');
        $item->first_name = $user->first_name ?? '';
        $item->last_name = $user->last_name ?? '';
        $item->street = $user->street ?? '';
        $item->city = $user->city ?? '';
        $item->postal_code = $user->postal_code ?? '';
        $item->province = $user->province ?? '';

        $item->account_type = app(UserAccountRoleService::class)->isAdmin(
            $user->roles ?? null,
            $user->roles_custom_advanced ?? null
        ) ? 'admin' : 'user';

        $item->shipping_firstName = $shippingAddress->firstName ?? '';
        $item->shipping_lastName = $shippingAddress->lastName ?? '';
        $item->shipping_street = $shippingAddress->street ?? '';
        $item->shipping_house_number = $shippingAddress->house_number ?? '';
        $item->shipping_city = $shippingAddress->city ?? '';
        $item->shipping_zipCode = $shippingAddress->zipCode ?? '';
        $item->shipping_phoneNumber = $shippingAddress->phoneNumber ?? '';
        $item->shipping_company = $shippingAddress->company ?? '';
        $item->shipping_state = $shippingAddress->state ?? '';

        return $item;
    }

    protected function buildAreas(): array
    {
        return [
            [
                'name' => 'Nazwa użytkownika',
                'type' => 'text',
                'field' => 'username',
                'editable' => true,
                'onList' => true,
                'onFilter' => true,
            ],
            [
                'name' => 'Adres e-mail',
                'type' => 'text',
                'field' => 'email',
                'editable' => true,
                'onList' => true,
                'onFilter' => true,
            ],
            [
                'name' => 'Aktywny',
                'type' => 'select',
                'field' => 'enabled',
                'editable' => true,
                'onList' => true,
                'onFilter' => true,
                'options' => [
                    '1' => 'Tak',
                    '0' => 'Nie',
                ],
            ],
            [
                'name' => 'Typ konta',
                'type' => 'select',
                'field' => 'account_type',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
                'options' => [
                    'user' => 'Użytkownik',
                    'admin' => 'Administrator',
                ],
            ],
            [
                'name' => 'Imię',
                'type' => 'text',
                'field' => 'first_name',
                'editable' => true,
                'onList' => true,
                'onFilter' => true,
            ],
            [
                'name' => 'Nazwisko',
                'type' => 'text',
                'field' => 'last_name',
                'editable' => true,
                'onList' => true,
                'onFilter' => true,
            ],
            [
                'name' => 'Ulica',
                'type' => 'text',
                'field' => 'street',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Miasto',
                'type' => 'text',
                'field' => 'city',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Kod pocztowy',
                'type' => 'text',
                'field' => 'postal_code',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Województwo',
                'type' => 'text',
                'field' => 'province',
                'editable' => true,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Nowe hasło',
                'type' => 'password',
                'field' => 'password_new',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
                'info' => 'Przy edycji pozostaw puste, jeśli hasło nie ma być zmieniane',
            ],
            [
                'name' => 'Powtórz nowe hasło',
                'type' => 'password',
                'field' => 'password_new_repeat',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Adres dostawy - imię',
                'type' => 'text',
                'field' => 'shipping_firstName',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Adres dostawy - nazwisko',
                'type' => 'text',
                'field' => 'shipping_lastName',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Adres dostawy - ulica',
                'type' => 'text',
                'field' => 'shipping_street',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Adres dostawy - numer domu / lokalu',
                'type' => 'text',
                'field' => 'shipping_house_number',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Adres dostawy - miasto',
                'type' => 'text',
                'field' => 'shipping_city',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Adres dostawy - kod pocztowy',
                'type' => 'text',
                'field' => 'shipping_zipCode',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Adres dostawy - telefon',
                'type' => 'text',
                'field' => 'shipping_phoneNumber',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Adres dostawy - firma',
                'type' => 'text',
                'field' => 'shipping_company',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
            [
                'name' => 'Adres dostawy - województwo / stan',
                'type' => 'text',
                'field' => 'shipping_state',
                'editable' => true,
                'saveToMainTable' => false,
                'onList' => false,
                'onFilter' => false,
            ],
        ];
    }
}
