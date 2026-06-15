<div style="max-width: 600px; margin: 0 auto; margin-top: 30px; border: 2px solid #38900D">
    <div style="background-color: #38900D; color: white; font-size: 23px; padding: 12px; text-align: center;">
        Apteka Wracam do zdrowia
    </div>

    <div style="padding: 10px; font-size: 15px; padding-top: 20px;">
        Dzień dobry,
        <br><br>

        {{-- MIEJSCE NA TEKST PRAWNY / TEKST OD PRAWNIKA --}}
        <div style="padding: 10px; background-color: #f6f6f6; border-left: 4px solid #38900D; margin-bottom: 15px;">
            Treść informacyjna, do uzupełnienia później
        </div>

        Dziękujemy za przesłanie zgłoszenia zwrotu.
        <br>
        Poniżej znajdują się szczegóły zgłoszenia.
        <br><br>
    </div>

    <div style="padding: 10px; font-size: 15px;">
        <p style="font-size: 17px; font-weight: 900;">
            <b>Szczegóły zgłoszenia:</b>
        </p>

        <table style="border-collapse: separate; border-spacing: 0px 5px; width: 100%;">
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D; width: 160px;">
                    Numer zgłoszenia
                </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">
                    #{{ $refund->id }}
                </td>
            </tr>

            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">
                    Zamówienie
                </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">
                    {{ $refund->order_identity }}
                </td>
            </tr>

            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">
                    Data zgłoszenia
                </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">
                    {{ $refund->created_at?->format('d.m.Y') }}
                </td>
            </tr>
        </table>

        <br>

        <p style="font-size: 17px; font-weight: 900;">
            <b>Dane osoby zgłaszającej zwrot:</b>
        </p>

        <table style="border-collapse: separate; border-spacing: 0px 5px; width: 100%;">
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D; width: 160px;">
                    Imię i nazwisko
                </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">
                    {{ $refund->first_name }} {{ $refund->last_name }}
                </td>
            </tr>

            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">
                    E-mail
                </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">
                    {{ $refund->email }}
                </td>
            </tr>

            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">
                    Telefon
                </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">
                    {{ $refund->phone }}
                </td>
            </tr>
        </table>

        <br>

        <p style="font-size: 17px; font-weight: 900; width: 100%">
            <b>Produkty zgłoszone do zwrotu:</b>
        </p>

        <table style="border-collapse: separate; border-spacing: 0px 5px; text-align: center; width: 100%;">
            <thead>
            <tr style="font-weight: 900; border-bottom: 1px solid #dfdfdf; border-top: 1px solid #dfdfdf; background-color: #38900D; color: white;">
                <th style="padding: 5px;">Nazwa</th>
                <th style="padding: 5px;">Cena brutto</th>
                <th style="padding: 5px;">Ilość</th>
                <th style="padding: 5px;">Suma</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($refund->products as $position)
                <tr style="border-bottom: 1px solid #dfdfdf;">
                    <td style="padding: 5px; text-align: left; border-bottom: 1px solid #38900D;">
                        {{ $position->product_name }}
                    </td>

                    <td style="padding: 5px; border-bottom: 1px solid #38900D;">
                        {{ number_format((float) $position->price_gross, 2, ',', ' ') }} zł
                    </td>

                    <td style="padding: 5px; border-bottom: 1px solid #38900D;">
                        {{ $position->quantity }}
                    </td>

                    <td style="padding: 5px; border-bottom: 1px solid #38900D;">
                        {{ number_format((float) $position->value_gross, 2, ',', ' ') }} zł
                    </td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3" style="text-align: right">
                    <p style="font-weight: 900; font-size: 16px;">
                        Wartość produktów zgłoszonych do zwrotu:
                    </p>
                </td>
                <td style="font-weight: 900; font-size: 16px;">
                    <p>{{ number_format((float) $refund->total_value_gross, 2, ',', ' ') }} zł</p>
                </td>
            </tr>
            </tbody>
        </table>

        <br><br>
    </div>

    <div style="padding: 10px; font-size: 15px;">
        <p>
            Pozdrawiamy<br>
            Zespół Apteki Wracam do zdrowia
        </p>

        <br>

        <p style="font-size: 12px; font-weight: 100">
            Apteka Wracam do zdrowia<br>
            Plac Górnośląski 16<br>
            81-509 Gdynia<br>
            Numer telefonu: 585 731 741<br>
            Adres e-mail: apteka@wdoz.pl
        </p>

        <p style="font-size: 12px; font-weight: 100">
            Podmiotem prowadzącym Aptekę Wracam do zdrowia, działającą pod adresem www.wracamdozdrowia.pl,
            jest spółka Wracam do zdrowia 8 spółka z ograniczoną odpowiedzialnością,
            adres: ul. Remusa 6, 81-574 Gdynia.
        </p>

        <p style="font-size: 12px; font-weight: 700">
            Produkty lecznicze, środki spożywcze specjalnego przeznaczenia żywieniowego i wyroby medyczne
            wydane z Apteki Internetowej nie podlegają zwrotowi, za wyjątkiem produktu leczniczego lub wyrobu
            medycznego zwracanego z powodu wady jakościowej, niewłaściwego ich wydania lub sfałszowania produktu leczniczego.
        </p>

        <p style="font-size: 12px; font-weight: 100">
            Więcej informacji w zakresie zamówień, zwrotów i reklamacji znajdą Państwo w Regulaminie oraz zakładce Reklamacje i zwroty.
        </p>
    </div>
</div>
