@extends('layouts.front')

@vite([
    'resources/css/app.css',
])
@vite('resources/js/refunds/order-lookup.js')
@section('content')
    <div class=" bg-wdoz-body-bg py-10">
        <form
            id="refund-form-root"
            method="POST"
            action="{{ route('refunds.store') }}"
            data-order-api-base="{{ url('/refunds/orders') }}"
            class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8"
        >
            @csrf

            <input type="hidden" id="order_id" name="order_id" value="{{ old('order_id') }}">
            <input type="hidden" id="order_identity_hidden" name="order_identity" value="{{ old('order_identity') }}">

            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-wdoz-text-gray">
                    Formularz zwrotu
                </h1>

                <p class="mt-3 max-w-2xl text-base leading-7 text-wdoz-text-gray">
                    Wpisz numer zamówienia, aby wyświetlić produkty dostępne w Twoim zamówieniu.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
                        autocomplete="off"
                        value="{{ $setId }}"
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

            <div id="customer_fields" class="mt-6 hidden rounded-2xl border border-wdoz-border bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-wdoz-text-gray">
                    Dane osoby zgłaszającej zwrot
                </h2>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-wdoz-text-gray">
                            Imię
                        </label>
                        <input
                            id="first_name"
                            name="first_name"
                            type="text"
                            value="{{ old('first_name') }}"
                            class="mt-2 h-11 w-full rounded-lg border border-wdoz-input-border px-3 text-sm text-wdoz-text-gray outline-none focus:border-wdoz-primary focus:ring-2 focus:ring-wdoz-primary-10"
                            required
                        >
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-wdoz-text-gray">
                            Nazwisko
                        </label>
                        <input
                            id="last_name"
                            name="last_name"
                            type="text"
                            value="{{ old('last_name') }}"
                            class="mt-2 h-11 w-full rounded-lg border border-wdoz-input-border px-3 text-sm text-wdoz-text-gray outline-none focus:border-wdoz-primary focus:ring-2 focus:ring-wdoz-primary-10"
                            required
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-wdoz-text-gray">
                            Adres e-mail
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            class="mt-2 h-11 w-full rounded-lg border border-wdoz-input-border px-3 text-sm text-wdoz-text-gray outline-none focus:border-wdoz-primary focus:ring-2 focus:ring-wdoz-primary-10"
                            required
                        >
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-wdoz-text-gray">
                            Numer telefonu
                        </label>
                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            value="{{ old('phone') }}"
                            class="mt-2 h-11 w-full rounded-lg border border-wdoz-input-border px-3 text-sm text-wdoz-text-gray outline-none focus:border-wdoz-primary focus:ring-2 focus:ring-wdoz-primary-10"
                            required
                        >
                    </div>
                </div>
            </div>

            <div id="products_container" class="mt-6 hidden space-y-4"></div>

            <div id="submit_container" class="mt-6 hidden rounded-2xl border border-wdoz-border bg-white p-6 text-right shadow-sm">
                <button
                    type="submit"
                    class="rounded-lg bg-wdoz-primary px-8 py-3 text-base font-semibold text-white transition hover:bg-wdoz-primary-900"
                >
                    Wyślij zgłoszenie zwrotu
                </button>
            </div>
        </form>
    </div>

@if ($setId != null && $setId != '')
<script>
setTimeout(function () {
  document.getElementById("find_order_btn").click();
}, 1000);
</script>
@endif
@endsection
