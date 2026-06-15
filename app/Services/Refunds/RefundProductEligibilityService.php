<?php

namespace App\Services\Refunds;

use App\Models\EcommerceOrderProducts;
use App\Models\EcommerceProducts;

class RefundProductEligibilityService
{
    public function check(EcommerceOrderProducts $orderProduct): array
    {
        $reasons = [];

        $product = null;

        if ($orderProduct->relationLoaded('product')) {
            $product = $orderProduct->product;
        }

        if (!$product && $orderProduct->product_id) {
            $product = EcommerceProducts::query()
                ->select(['id', 'type_of_preparation'])
                ->where('id', $orderProduct->product_id)
                ->first();
        }

        $typeOfPreparation = (string) ($product?->type_of_preparation ?? '');

        if ($this->isMedicine($typeOfPreparation)) {
            $reasons[] = 'Zgodnie z ustawą leki nie podlegają zwrotowi.';
        }

        return [
            'can_return' => count($reasons) === 0,
            'reasons' => $reasons,
            'debug' => [
                'product_id' => $orderProduct->product_id,
                'type_of_preparation' => $typeOfPreparation,
            ],
        ];
    }

    private function isMedicine(string $typeOfPreparation): bool
    {
        $value = str_replace("\xc2\xa0", ' ', $typeOfPreparation);
        $value = trim($value);

        if ($value === '') {
            return false;
        }

        return preg_match('/^lek\b/ui', $value) === 1;
    }
}
