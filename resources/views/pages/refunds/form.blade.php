@extends('layouts.front')

@vite([
    'resources/css/app.css',
    'resources/js/refunds/order-lookup.js'
])

@section('content')
    <div class=" bg-wdoz-body-bg py-10 py-1000 py-100">
        <div
            id="refund-form-root"
            data-order-api-base="{{ url('/api/refunds/orders') }}"
            class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8"
        >
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-wdoz-text-gray">
                    Formularz zwrotu
                </h1>

                <p class="mt-3 max-w-2xl text-base leading-7 text-wdoz-text-gray">
                    Wpisz numer zamówienia, aby wyświetlić produkty dostępne w Twoim zamówieniu.
                </p>
            </div>

            <div class="rounded-2xl border border-wdoz-border bg-white p-6 shadow-sm">
                <label for="order_identity" class="block text-sm font-semibold text-wdoz-text-gray">
                    Numer zamówienia
                </label>

                <div class="mt-3 flex flex-col gap-3 sm:flex-row">
                    <input
                        id="order_identity"
                        type="text"
                        autocomplete="off"
                        placeholder="np. 123456"
                        class="h-12 w-full rounded-lg border border-wdoz-input-border bg-white px-4 text-base text-wdoz-text-gray outline-none transition focus:border-wdoz-primary focus:ring-2 focus:ring-wdoz-primary-10"
                    >

                    <button
                        id="find_order_btn"
                        type="button"
                        class="h-12 rounded-lg bg-wdoz-primary px-6 text-base font-semibold text-white transition hover:bg-wdoz-primary-900 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        Sprawdź
                    </button>
                </div>

                <p id="refund_message" class="mt-4 hidden rounded-lg px-4 py-3 text-sm"></p>
            </div>

            <div id="order_summary" class="mt-6 hidden rounded-2xl border border-wdoz-border bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-wdoz-text-gray">Zamówienie</p>
                        <h2 id="summary_identity" class="text-xl font-semibold text-wdoz-text-gray"></h2>
                    </div>

                    <div class="text-left sm:text-right">
                        <p id="summary_date" class="text-sm text-wdoz-text-gray"></p>
                        <p id="summary_value" class="text-lg font-semibold text-wdoz-primary"></p>
                    </div>
                </div>
            </div>

            <div id="products_container" class="mt-6 hidden space-y-4"></div>
        </div>
    </div>
@endsection
