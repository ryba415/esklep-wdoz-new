<?php

namespace App\Services\Cms;

use App\Models\AdminUserAccountsBase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminUserAccountDeleteService
{
    public function delete(int $itemId, AdminUserAccountsBase $modelObject): array
    {
        try {
            $currentAdminId = Auth::id();

            if ($currentAdminId !== null && (int)$currentAdminId === (int)$itemId) {
                return [
                    'status' => false,
                    'message' => 'Nie możesz usunąć aktualnie zalogowanego administratora',
                ];
            }

            $db = DB::connection('mysql-esklep');

            $user = $db->table('fos_user')
                ->where('id', $itemId)
                ->first();

            if (!$user) {
                return [
                    'status' => false,
                    'message' => 'Nie znaleziono użytkownika do usunięcia',
                ];
            }

            $db->beginTransaction();

            if (!empty($user->shipping_address_id)) {
                $db->table('fos_user_shipping_address')
                    ->where('id', $user->shipping_address_id)
                    ->delete();
            }

            $db->commit();

            return [
                'status' => true,
            ];
        } catch (Throwable $e) {
            DB::connection('mysql-esklep')->rollBack();

            Log::error('Błąd usuwania konta użytkownika CMS', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'status' => false,
                'message' => 'Wystąpił błąd podczas usuwania konta użytkownika',
            ];
        }
    }
}
