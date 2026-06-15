@extends('layouts.front')

<link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?v={{ filemtime(public_path('css/tailwind.css')) }}">

@section('content')
    <div class=" bg-wdoz-body-bg py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-wdoz-border bg-white p-8 text-center shadow-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-wdoz-primary-10 text-3xl text-wdoz-primary">
                    ✓
                </div>

                <h1 class="mt-6 text-3xl font-semibold text-wdoz-text-gray">
                    Dziękujemy za zgłoszenie zwrotu
                </h1>

                <p class="mt-4 text-base leading-7 text-wdoz-text-gray">
                    Twoje zgłoszenie zostało zapisane. Potwierdzenie zostało wysłane na podany adres e-mail.
                </p>

                <div class="mt-6 rounded-xl bg-wdoz-primary-10 px-5 py-4 text-left">
                    <p class="text-sm text-wdoz-text-gray">
                        Numer zgłoszenia:
                        <strong class="text-wdoz-primary">#{{ $refund->id }}</strong>
                    </p>

                    <p class="mt-2 text-sm text-wdoz-text-gray">
                        Zgłoszenie dotyczy zamówienia:
                        <strong class="text-wdoz-primary">{{ $refund->order_identity }}</strong>
                    </p>
                </div>

                <a
                    href="{{ route('refunds.form') }}"
                    class="mt-8 inline-flex rounded-lg bg-wdoz-primary px-6 py-3 text-base font-semibold text-white transition hover:bg-wdoz-primary-900"
                >
                    Wróć do formularza
                </a>
            </div>
        </div>
    </div>
@endsection
