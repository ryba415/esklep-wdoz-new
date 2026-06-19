<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EcommerceOrders;
use App\Models\EcommerceOrderProducts;
use App\Services\Refunds\RefundProductEligibilityService;
use Illuminate\Http\JsonResponse;

class RefundOrderController extends Controller
{
    public function show(
        string $identity,
        RefundProductEligibilityService $eligibilityService
    ): JsonResponse {
        $order = EcommerceOrders::query()
            ->where('identity', $identity)
            ->with('products.product')
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'Nie znaleziono zamówienia o podanym numerze.',
            ], 404);
        }

        return response()->json([
            'order' => [
                'id' => $order->id,
                'identity' => $order->identity,
                'name' => $order->name,
                'order_date' => optional($order->order_date)->format('Y-m-d H:i'),
                'status' => $order->status,
                'value_gross' => (float) $order->value_gross,
            ],
            'products' => $order->products->map(function (EcommerceOrderProducts $product) use ($eligibilityService) {
                $eligibility = $eligibilityService->check($product);

                return [
                    'id' => $product->id,
                    'product_id' => $product->product_id,
                    'name' => $product->display_name,
                    'image_url' => $product->display_image_url,
                    'price_gross' => (float) $product->price_gross,
                    'quantity' => (int) $product->quantity,
                    'value_gross' => (float) $product->value_gross,
                    'type_of_preparation' => $product->product?->type_of_preparation,
                    'can_return' => $eligibility['can_return'],
                    'return_exclusion_reasons' => $eligibility['reasons'],
//                    'debug' => $eligibility['debug'],
                ];
            })->values(),
        ]);
    }
}
