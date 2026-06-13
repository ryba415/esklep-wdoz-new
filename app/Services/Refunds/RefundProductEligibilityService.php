<?php

namespace App\Services\Refunds;

use App\Models\EcommerceOrderProducts;

class RefundProductEligibilityService
{
    public function check(EcommerceOrderProducts $orderProduct): array
    {
        $reasons = [];

        /*
         * TODO:
         * Gdy dostaniesz informację, gdzie w bazie jest oznaczenie leku OTC,
         * dopniesz tu warunek, np.:
         *
         * if ((bool) $orderProduct->product?->is_otc) {
         *     $reasons[] = 'Zgodnie z ustawą leki nie podlegają zwrotowi.';
         * }
         */

        return [
            'can_return' => count($reasons) === 0,
            'reasons' => $reasons,
        ];
    }
}
