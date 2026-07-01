<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Mail\EcommerceRefundSubmitted;
use App\Models\EcommerceOrders;
use App\Models\EcommerceRefund;
use App\Models\EcommerceRefundProduct;
use App\Services\Refunds\RefundProductEligibilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RefundFormController extends Controller
{
    public function index(Request $request): View
    {
        $requestData = $request->all();
        
        $setId = '';
        
        if (isset($requestData['set-id']) && $requestData['set-id'] != null){
            $setId = $requestData['set-id'];
        }
        return view('pages.refunds.form',['setId' => $setId]);
    }

    public function store(
        Request $request,
        RefundProductEligibilityService $eligibilityService
    ): RedirectResponse {
        $validated = $request->validate([
            'order_id' => ['required', 'integer'],
            'order_identity' => ['required', 'string', 'max:30'],

            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],

            'products' => ['required', 'array'],
        ], [
            'first_name.required' => 'Podaj imię.',
            'last_name.required' => 'Podaj nazwisko.',
            'email.required' => 'Podaj adres e-mail.',
            'email.email' => 'Podaj poprawny adres e-mail.',
            'phone.required' => 'Podaj numer telefonu.',
            'products.required' => 'Wybierz przynajmniej jeden produkt do zwrotu.',
        ]);

        $order = EcommerceOrders::on('mysql-esklep')
            ->where('id', $validated['order_id'])
            ->where('identity', $validated['order_identity'])
            ->with('products.product')
            ->first();

        if (!$order) {
            throw ValidationException::withMessages([
                'order_identity' => 'Nie znaleziono zamówienia.',
            ]);
        }

        $selectedProducts = collect($request->input('products', []))
            ->filter(function (array $productData) {
                return isset($productData['selected']) && (string) $productData['selected'] === '1';
            });

        if ($selectedProducts->isEmpty()) {
            throw ValidationException::withMessages([
                'products' => 'Wybierz przynajmniej jeden produkt do zwrotu.',
            ]);
        }

        $orderProductsById = $order->products->keyBy('id');

        $productsToRefund = [];
        $totalValueGross = 0;

        foreach ($selectedProducts as $orderProductId => $productData) {
            $orderProduct = $orderProductsById->get((int) $orderProductId);

            if (!$orderProduct) {
                throw ValidationException::withMessages([
                    'products' => 'Wybrano produkt, który nie należy do tego zamówienia.',
                ]);
            }

            $eligibility = $eligibilityService->check($orderProduct);

            if (!$eligibility['can_return']) {
                throw ValidationException::withMessages([
                    'products' => 'Produkt "' . $orderProduct->display_name . '" nie może zostać zwrócony.',
                ]);
            }

            $quantity = (int) ($productData['quantity'] ?? 0);

            if ($quantity < 1) {
                throw ValidationException::withMessages([
                    'products' => 'Ilość produktu "' . $orderProduct->display_name . '" musi być większa od zera.',
                ]);
            }

            if ($quantity > (int) $orderProduct->quantity) {
                throw ValidationException::withMessages([
                    'products' => 'Nie możesz zwrócić większej liczby sztuk produktu "' . $orderProduct->display_name . '" niż kupiono.',
                ]);
            }

            $priceGross = (float) $orderProduct->price_gross;
            $valueGross = round($priceGross * $quantity, 2);

            $totalValueGross += $valueGross;

            $productsToRefund[] = [
                'order_product' => $orderProduct,
                'quantity' => $quantity,
                'price_gross' => $priceGross,
                'value_gross' => $valueGross,
            ];
        }

        $refund = DB::connection('mysql-esklep')->transaction(function () use ($validated, $order, $productsToRefund, $totalValueGross) {
            $refund = EcommerceRefund::on('mysql-esklep')->create([
                'order_id' => $order->id,
                'order_identity' => $order->identity,

                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],

                'status' => 'new',
                'total_value_gross' => $totalValueGross,
                'meta' => [
                    'order_name' => $order->name,
                    'order_email' => $order->email,
                    'order_phone' => $order->phone,
                ],
            ]);

            foreach ($productsToRefund as $productToRefund) {
                $orderProduct = $productToRefund['order_product'];

                EcommerceRefundProduct::on('mysql-esklep')->create([
                    'ecommerce_refund_id' => $refund->id,
                    'ecommerce_order_product_id' => $orderProduct->id,
                    'product_id' => $orderProduct->product_id,
                    'product_name' => $orderProduct->display_name,
                    'product_image_url' => $orderProduct->display_image_url,
                    'quantity' => $productToRefund['quantity'],
                    'price_gross' => $productToRefund['price_gross'],
                    'value_gross' => $productToRefund['value_gross'],
                    'meta' => [
                        'type_of_preparation' => $orderProduct->product?->type_of_preparation,
                        'order_quantity' => $orderProduct->quantity,
                    ],
                ]);
            }

            return $refund;
        });

        $refund->load('products');

        foreach (array_unique([$refund->email, 'darek@datum.pl', 'ryba415@gmail.com']) as $recipient) {
            Mail::to($recipient)->send(new EcommerceRefundSubmitted($refund));
        }

        return redirect()->route('refunds.thank-you', $refund);
    }

    public function thankYou($refund): View
    {
        $refund = EcommerceRefund::on('mysql-esklep')
            ->where('order_id', $refund)
            ->first();
                
        return view('pages.refunds.thank-you', [
            'refund' => $refund,
        ]);
    }
}
