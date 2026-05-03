<?php

namespace App\Services\Cms;

use App\Models\AdminUserAccountsBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminUserAccountSaveService
{
    protected UserAccountRoleService $roleService;

    public function __construct(UserAccountRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function save(Request $request, AdminUserAccountsBase $modelObject): array
    {
        $status = true;
        $errors = [];
        $errorsAreas = [];
        $userUnloged = false;
        $sucessSaveInfoText = '';

        $postData = $request->all();
        $editElemId = $postData['id']['value'] ?? null;

        $userId = Auth::id();
        if ($userId == null) {
            return [
                'status' => false,
                'errors' => ['Sesja wygasła - użytkownik wylogowany'],
                'errorsAreas' => [],
                'editElemId' => $editElemId,
                'sucessSaveInfoText' => '',
                'userUnloged' => true
            ];
        }

        $db = DB::connection('mysql-esklep');
        $currentEditItem = null;

        if (!empty($editElemId)) {
            $currentEditItem = $db->table('fos_user')
                ->where('id', $editElemId)
                ->first();

            if (!$currentEditItem) {
                return [
                    'status' => false,
                    'errors' => ['Nie znaleziono edytowanego użytkownika'],
                    'errorsAreas' => [],
                    'editElemId' => $editElemId,
                    'sucessSaveInfoText' => '',
                    'userUnloged' => false
                ];
            }
        }

        $username = trim((string)$this->getPostedValue($postData, 'username'));
        $email = trim((string)$this->getPostedValue($postData, 'email'));
        $enabled = trim((string)$this->getPostedValue($postData, 'enabled', '1'));
        $accountType = trim((string)$this->getPostedValue($postData, 'account_type', $modelObject->getAccountManagerType()));

        $firstName = trim((string)$this->getPostedValue($postData, 'first_name'));
        $lastName = trim((string)$this->getPostedValue($postData, 'last_name'));
        $street = trim((string)$this->getPostedValue($postData, 'street'));
        $city = trim((string)$this->getPostedValue($postData, 'city'));
        $postalCode = trim((string)$this->getPostedValue($postData, 'postal_code'));
        $province = trim((string)$this->getPostedValue($postData, 'province'));

        $passwordNew = (string)$this->getPostedValue($postData, 'password_new');
        $passwordNewRepeat = (string)$this->getPostedValue($postData, 'password_new_repeat');

        $shippingData = [
            'firstName' => trim((string)$this->getPostedValue($postData, 'shipping_firstName')),
            'lastName' => trim((string)$this->getPostedValue($postData, 'shipping_lastName')),
            'street' => trim((string)$this->getPostedValue($postData, 'shipping_street')),
            'house_number' => trim((string)$this->getPostedValue($postData, 'shipping_house_number')),
            'city' => trim((string)$this->getPostedValue($postData, 'shipping_city')),
            'zipCode' => trim((string)$this->getPostedValue($postData, 'shipping_zipCode')),
            'phoneNumber' => trim((string)$this->getPostedValue($postData, 'shipping_phoneNumber')),
            'company' => trim((string)$this->getPostedValue($postData, 'shipping_company')),
            'state' => trim((string)$this->getPostedValue($postData, 'shipping_state')),
        ];

        if ($username === '') {
            $status = false;
            $errors[] = 'Pole: Nazwa użytkownika nie może pozostać puste';
            $errorsAreas[] = 'username';
        } elseif (mb_strlen($username) > 255) {
            $status = false;
            $errors[] = 'Pole: Nazwa użytkownika może mieć maksymalnie 255 znaków';
            $errorsAreas[] = 'username';
        }

        if ($email === '') {
            $status = false;
            $errors[] = 'Pole: Adres e-mail nie może pozostać puste';
            $errorsAreas[] = 'email';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $status = false;
            $errors[] = 'Pole: Adres e-mail ma nieprawidłowy format';
            $errorsAreas[] = 'email';
        } elseif (mb_strlen($email) > 255) {
            $status = false;
            $errors[] = 'Pole: Adres e-mail może mieć maksymalnie 255 znaków';
            $errorsAreas[] = 'email';
        }

        if ($enabled !== '0' && $enabled !== '1') {
            $status = false;
            $errors[] = 'Pole: Aktywny ma nieprawidłową wartość';
            $errorsAreas[] = 'enabled';
        }

        if (!in_array($accountType, ['user', 'admin'], true)) {
            $status = false;
            $errors[] = 'Pole: Typ konta ma nieprawidłową wartość';
            $errorsAreas[] = 'account_type';
        }

        $this->validateMaxLength($firstName, 255, 'first_name', 'Imię', $status, $errors, $errorsAreas);
        $this->validateMaxLength($lastName, 255, 'last_name', 'Nazwisko', $status, $errors, $errorsAreas);
        $this->validateMaxLength($street, 255, 'street', 'Ulica', $status, $errors, $errorsAreas);
        $this->validateMaxLength($city, 255, 'city', 'Miasto', $status, $errors, $errorsAreas);
        $this->validateMaxLength($postalCode, 255, 'postal_code', 'Kod pocztowy', $status, $errors, $errorsAreas);
        $this->validateMaxLength($province, 255, 'province', 'Województwo', $status, $errors, $errorsAreas);

        $this->validateMaxLength($shippingData['firstName'], 255, 'shipping_firstName', 'Adres dostawy - imię', $status, $errors, $errorsAreas);
        $this->validateMaxLength($shippingData['lastName'], 255, 'shipping_lastName', 'Adres dostawy - nazwisko', $status, $errors, $errorsAreas);
        $this->validateMaxLength($shippingData['street'], 100, 'shipping_street', 'Adres dostawy - ulica', $status, $errors, $errorsAreas);
        $this->validateMaxLength($shippingData['house_number'], 15, 'shipping_house_number', 'Adres dostawy - numer domu / lokalu', $status, $errors, $errorsAreas);
        $this->validateMaxLength($shippingData['city'], 255, 'shipping_city', 'Adres dostawy - miasto', $status, $errors, $errorsAreas);
        $this->validateMaxLength($shippingData['zipCode'], 255, 'shipping_zipCode', 'Adres dostawy - kod pocztowy', $status, $errors, $errorsAreas);
        $this->validateMaxLength($shippingData['phoneNumber'], 20, 'shipping_phoneNumber', 'Adres dostawy - telefon', $status, $errors, $errorsAreas);
        $this->validateMaxLength($shippingData['company'], 255, 'shipping_company', 'Adres dostawy - firma', $status, $errors, $errorsAreas);
        $this->validateMaxLength($shippingData['state'], 100, 'shipping_state', 'Adres dostawy - województwo / stan', $status, $errors, $errorsAreas);

        if ($this->usernameExists($db, $username, $editElemId)) {
            $status = false;
            $errors[] = 'Użytkownik z taką nazwą już istnieje';
            $errorsAreas[] = 'username';
        }

        if ($this->emailExists($db, $email, $editElemId)) {
            $status = false;
            $errors[] = 'Użytkownik z takim adresem e-mail już istnieje';
            $errorsAreas[] = 'email';
        }

        $passwordChangeRequested = ($passwordNew !== '' || $passwordNewRepeat !== '' || empty($editElemId));

        if ($passwordChangeRequested) {
            if ($passwordNew === '') {
                $status = false;
                $errors[] = 'Pole: Nowe hasło nie może pozostać puste';
                $errorsAreas[] = 'password_new';
            }

            if ($passwordNewRepeat === '') {
                $status = false;
                $errors[] = 'Pole: Powtórz nowe hasło nie może pozostać puste';
                $errorsAreas[] = 'password_new_repeat';
            }

            if ($passwordNew !== '' && mb_strlen($passwordNew) < 7) {
                $status = false;
                $errors[] = 'Hasło musi mieć conajmniej 7 znaków';
                $errorsAreas[] = 'password_new';
            }

            if ($passwordNew !== '' && strlen(preg_replace('/[^A-Z]/', '', $passwordNew)) < 1) {
                $status = false;
                $errors[] = 'Hasło musi mieć conajmniej jedną wielką literę';
                $errorsAreas[] = 'password_new';
            }

            if ($passwordNew !== '' && strlen(preg_replace('/[^a-z]/', '', $passwordNew)) < 1) {
                $status = false;
                $errors[] = 'Hasło musi mieć conajmniej jedną małą literę';
                $errorsAreas[] = 'password_new';
            }

            if ($passwordNew !== '' && $passwordNewRepeat !== '' && $passwordNew !== $passwordNewRepeat) {
                $status = false;
                $errors[] = 'Hasło i powtórzenie hasła różnią się';
                $errorsAreas[] = 'password_new_repeat';
            }
        }

        if (!$status) {
            return [
                'status' => false,
                'errors' => array_values(array_unique($errors)),
                'errorsAreas' => array_values(array_unique($errorsAreas)),
                'editElemId' => $editElemId,
                'sucessSaveInfoText' => '',
                'userUnloged' => $userUnloged
            ];
        }

        try {
            $db->beginTransaction();

            $roleData = $this->roleService->getRoleDataForAccountType($accountType);
            $usernameCanonical = mb_strtolower($username);
            $emailCanonical = mb_strtolower($email);

            $shippingAddressId = $currentEditItem->shipping_address_id ?? null;

            if (empty($shippingAddressId)) {
                $shippingAddressId = $db->table('fos_user_shipping_address')->insertGetId(
                    $this->prepareShippingDataForSave($shippingData)
                );
            } else {
                $db->table('fos_user_shipping_address')
                    ->where('id', $shippingAddressId)
                    ->update($this->prepareShippingDataForSave($shippingData));
            }

            if (empty($editElemId)) {
                $salt = $this->generateRandomString(35);
                $passwordHash = $this->buildLegacyPasswordHash($passwordNew, $salt);

                $insertData = [
                    'username' => $username,
                    'username_canonical' => $usernameCanonical,
                    'email' => $email,
                    'email_canonical' => $emailCanonical,
                    'enabled' => (int)$enabled,
                    'salt' => $salt,
                    'password' => $passwordHash,
                    'locked' => 0,
                    'expired' => 0,
                    'confirmation_token' => $this->generateRandomString(45),
                    'roles' => $roleData['roles'],
                    'credentials_expired' => 0,
                    'first_name' => $firstName !== '' ? $firstName : null,
                    'last_name' => $lastName !== '' ? $lastName : null,
                    'street' => $street !== '' ? $street : null,
                    'city' => $city !== '' ? $city : null,
                    'postal_code' => $postalCode !== '' ? $postalCode : null,
                    'province' => $province !== '' ? $province : null,
                    'shipping_address_id' => $shippingAddressId,
                ];

                $this->setOptionalColumnValue($db, $insertData, 'fos_user', 'roles_custom_advanced', $roleData['roles_custom_advanced']);
                $this->setOptionalColumnValue($db, $insertData, 'fos_user', 'last_login', null);
                $this->setOptionalColumnValue($db, $insertData, 'fos_user', 'expires_at', null);
                $this->setOptionalColumnValue($db, $insertData, 'fos_user', 'password_requested_at', null);
                $this->setOptionalColumnValue($db, $insertData, 'fos_user', 'credentials_expire_at', null);
                $this->setOptionalColumnValue($db, $insertData, 'fos_user', 'facebook_id', null);
                $this->setOptionalColumnValue($db, $insertData, 'fos_user', 'facebook_access_token', null);
                $this->setOptionalColumnValue($db, $insertData, 'fos_user', 'basket_id', null);
                $this->setOptionalColumnValue($db, $insertData, 'fos_user', 'login_fails_count', 0);

                $editElemId = $db->table('fos_user')->insertGetId($insertData);

                if (!$editElemId) {
                    throw new \RuntimeException('Nie udało się utworzyć użytkownika');
                }
            } else {
                $salt = $currentEditItem->salt ?: $this->generateRandomString(35);

                $updateData = [
                    'username' => $username,
                    'username_canonical' => $usernameCanonical,
                    'email' => $email,
                    'email_canonical' => $emailCanonical,
                    'enabled' => (int)$enabled,
                    'roles' => $roleData['roles'],
                    'roles_custom_advanced' => $roleData['roles_custom_advanced'],
                    'first_name' => $firstName !== '' ? $firstName : null,
                    'last_name' => $lastName !== '' ? $lastName : null,
                    'street' => $street !== '' ? $street : null,
                    'city' => $city !== '' ? $city : null,
                    'postal_code' => $postalCode !== '' ? $postalCode : null,
                    'province' => $province !== '' ? $province : null,
                    'shipping_address_id' => $shippingAddressId,
                ];

                if (empty($currentEditItem->salt)) {
                    $updateData['salt'] = $salt;
                }

                if ($passwordNew !== '') {
                    $updateData['password'] = $this->buildLegacyPasswordHash($passwordNew, $salt);
                }

                $db->table('fos_user')
                    ->where('id', $editElemId)
                    ->update($updateData);
            }

            $db->commit();

            $sucessSaveInfoText = $modelObject->sucessSaveInfoText;

            return [
                'status' => true,
                'errors' => [],
                'errorsAreas' => [],
                'editElemId' => $editElemId,
                'sucessSaveInfoText' => $sucessSaveInfoText,
                'userUnloged' => false
            ];
        } catch (Throwable $e) {
            $db->rollBack();

            Log::error('Błąd zapisu konta użytkownika CMS', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'status' => false,
                'errors' => ['Wystąpił wewnętrzny błąd podczas próby zapisu konta'],
                'errorsAreas' => [],
                'editElemId' => $editElemId,
                'sucessSaveInfoText' => '',
                'userUnloged' => false
            ];
        }
    }

    private function getPostedValue(array $postData, string $field, $default = '')
    {
        if (!isset($postData[$field])) {
            return $default;
        }

        if (is_array($postData[$field]) && array_key_exists('value', $postData[$field])) {
            return $postData[$field]['value'];
        }

        return $postData[$field];
    }

    private function validateMaxLength(
        string $value,
        int $maxLength,
        string $field,
        string $label,
        bool &$status,
        array &$errors,
        array &$errorsAreas
    ): void {
        if ($value !== '' && mb_strlen($value) > $maxLength) {
            $status = false;
            $errors[] = 'Pole: ' . $label . ' może mieć maksymalnie ' . $maxLength . ' znaków';
            $errorsAreas[] = $field;
        }
    }

    private function usernameExists($db, string $username, $currentId = null): bool
    {
        $usernameCanonical = mb_strtolower($username);

        $query = $db->table('fos_user')
            ->where(function ($subQuery) use ($username, $usernameCanonical) {
                $subQuery->where('username', $username)
                    ->orWhere('username_canonical', $usernameCanonical);
            });

        if (!empty($currentId)) {
            $query->where('id', '!=', $currentId);
        }

        return $query->exists();
    }

    private function emailExists($db, string $email, $currentId = null): bool
    {
        $emailCanonical = mb_strtolower($email);

        $query = $db->table('fos_user')
            ->where(function ($subQuery) use ($email, $emailCanonical) {
                $subQuery->where('email', $email)
                    ->orWhere('email_canonical', $emailCanonical);
            });

        if (!empty($currentId)) {
            $query->where('id', '!=', $currentId);
        }

        return $query->exists();
    }

    private function prepareShippingDataForSave(array $shippingData): array
    {
        return [
            'firstName' => $shippingData['firstName'] ?? '',
            'lastName' => $shippingData['lastName'] ?? '',
            'street' => $shippingData['street'] ?? '',
            'house_number' => $shippingData['house_number'] ?? '',
            'city' => $shippingData['city'] ?? '',
            'company' => $shippingData['company'] ?? '',
            'zipCode' => $shippingData['zipCode'] ?? '',
            'phoneNumber' => $shippingData['phoneNumber'] ?? '',
            'state' => $shippingData['state'] ?? '',
        ];
    }

    private function buildLegacyPasswordHash(string $password, string $salt): string
    {
        $salted = $password . '{' . $salt . '}';
        $digiest = hash('sha512', $salted, true);

        for ($i = 1; $i < 5000; $i++) {
            $digiest = hash('sha512', $digiest . $salted, true);
        }

        return base64_encode($digiest);
    }

    private function generateRandomString(int $length = 10): string
    {
        return substr(
            str_shuffle(
                str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / 62))
            ),
            1,
            $length
        );
    }

    private function setOptionalColumnValue($db, array &$data, string $table, string $column, $value): void
    {
        if ($db->getSchemaBuilder()->hasColumn($table, $column)) {
            $data[$column] = $value;
        }
    }
}
