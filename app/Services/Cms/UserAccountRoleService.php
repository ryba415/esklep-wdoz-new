<?php

namespace App\Services\Cms;

class UserAccountRoleService
{
    public const USER_ROLES = 'a:0:{}';
    public const ADMIN_ROLES = 'a:3:{i:0;s:10:"ROLE_ADMIN";i:1;s:16:"ROLE_SUPER_ADMIN";i:2;s:17:"ROLE_SONATA_ADMIN";}';
    public const ADMIN_ADVANCED_ROLE = 'superadmin';

    public function isAdmin(?string $roles, ?string $rolesCustomAdvanced): bool
    {
        //Tutaj sprawdzanie czy jest adminem
        return str_contains((string)$roles, 'ROLE_SUPER_ADMIN')
            && trim((string)$rolesCustomAdvanced) === self::ADMIN_ADVANCED_ROLE;
    }

    public function applyAccountTypeScope($query, string $accountType): void
    {
        if ($accountType === 'admin') {
            //Tutaj sprawdzanie czy jest adminem
            $query->where('roles', 'LIKE', '%ROLE_SUPER_ADMIN%')
                ->where('roles_custom_advanced', self::ADMIN_ADVANCED_ROLE);

            return;
        }

        $query->where(function ($subQuery) {
            //Tutaj sprawdzanie czy jest adminem
            $subQuery->whereNull('roles_custom_advanced')
                ->orWhere('roles_custom_advanced', '!=', self::ADMIN_ADVANCED_ROLE)
                ->orWhere('roles', 'NOT LIKE', '%ROLE_SUPER_ADMIN%');
        });
    }

    public function getRoleDataForAccountType(string $accountType): array
    {
        if ($accountType === 'admin') {
            return [
                'roles' => self::ADMIN_ROLES,
                'roles_custom_advanced' => self::ADMIN_ADVANCED_ROLE,
            ];
        }

        return [
            'roles' => self::USER_ROLES,
            'roles_custom_advanced' => null,
        ];
    }
}
