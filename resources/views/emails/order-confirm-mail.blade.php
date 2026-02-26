<div style="max-width: 600px; margin: 0 auto; margin-top: 30px; border: 2px solid #38900D">
    <div style="background-color: #38900D; color: white; font-size: 23px; padding: 12px; text-align: center;">Apteka Wracam do zdrowia</div>

    <div style="padding: 10px; font-size: 15px; padding-top: 20px;">
    Dzień Dobry, 
    <br><br>
    Dziękujemy za złożenie zamówienia w naszej aptece. Rozpoczniemy jego realizację po zaksięgowaniu płatności. Napiszemy do Ciebie ponownie, gdy Twoje zamówienie zostanie przekazane do realizacji. 
    <br>
    Poniżej znajdą Państwo szczegóły zamówienia. W razie potrzeby zmiany zamówienia prosimy o kontakt:
    <a href="mailto:apteka@wdoz.pl">apteka@wdoz.pl</a> . <br>
    </div>
    
    
    <div style="padding: 10px; font-size: 15px;">
        @if ($order->payment_type != 'przelewpaynow')
            <p style="font-size: 17px; font-weight: 900;"><b>Płatność za zamówienie:</b></p>
            <div style="padding: 10px; font-size: 15px; padding-top: 0px;">
            W celu opłacenia zamówienia prosimy o dokananie przelewu na poniższy rachunek bankowy:<br><br>
            <strong>{{Config::get('constants.bank_acount_recipent')}}</strong><br>
            <strong>{{Config::get('constants.bank_acount_number')}}</strong><br>
            kwota: <strong data-checkout-destionation="full-price">{{number_format(floatval($order->value_gross), 2,',',' ')}} zł</strong><br><br>
            W tytule płatności prosimy wpisać: <strong>zamówienie</strong> <strong>{{$order->name}}</strong><br>
            </div>
        @endif
        <p style="font-size: 17px; font-weight: 900;"><b>Szczegóły zamówienia:</b></p>
        <table style="border-collapse: separate; border-spacing: 0px 5px;  width: 100%;">
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D; width: 140px;">Zamówienie nr </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">{{$order->name}}</td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 4px 8px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">Status zamówienia </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">w trakcie realizacji</td>
            </tr>
        </table>
        <br>
        
        <p style="font-size: 17px; font-weight: 900;"><b>Dane zamawiającego:</b></p>
        <table style="border-collapse: separate; border-spacing: 0px 5px;  width: 100%;">
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;  width: 140px;">Adres e-mail </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">{{$order->email}}</td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;  width: 140px;">Imię nazwisko </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">{{$order->recipient}}</td>
            </tr>
            @if ($order->paczkomat_details == '' || $order->paczkomat_details == null)
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">Adres </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">ul. {{$order->delivery_data}}</td>
            </tr>
            @endif
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">Tel. </td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">{{$order->phone}}</td>
            </tr>
        </table>
        <br>
        @if ($order->with_invoice == 1)
            <p style="font-size: 17px; font-weight: 900;"><b>Dane do faktury @if ($order->vat_number == '' || $order->vat_number == null) (na osobę fizyczną) @endif:</b></p>
            <table style="border-collapse: separate; border-spacing: 0px 5px;  width: 100%;">
                <tr>
                    <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;  width: 140px;">@if ($order->vat_number != '' && $order->vat_number != null)Nazwa firmy @else Imię i nazwisko @endif</td>
                    <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">{{$order->company_name}}</td>
                </tr>
                @if ($order->vat_number != '' and $order->vat_number != null)
                <tr>
                    <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">Numer NIP </td>
                    <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">{{$order->vat_number}}</td>
                </tr>
                @endif
                <tr>
                    <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">Miasto i  kod pcoztowy </td>
                    <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">{{$order->town}}&nbsp; &nbsp; &nbsp; {{$order->postal_code}}</td>
                </tr>
                <tr>
                    <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">Ulica </td>
                    <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">ul. {{str_replace("UL ", "", str_replace("UL. ", "", str_replace("Ul ", "", str_replace("Ul. ", "", str_replace("ul ", "", str_replace("ul. ", "", $order->street))))))}}</td>
                </tr>
            </table>
            <br>
        @endif
        
        <p style="font-size: 17px; font-weight: 900; width: 100%"><b>Zamówione produkty:</b></p>
        <table style="border-collapse: separate; border-spacing: 0px 5px; text-align: center; width: 100%;">
            <thead>
                <tr style="font-weight: 900; border-bottom: 1px solid #dfdfdf; border-top: 1px solid #dfdfdf; background-color: #38900D; color: white;">
                    <th style="padding: 5px;">Nazwa</th>
                    <th style="padding: 5px;">Netto</th>
                    <th style="padding: 5px;">Vat</th>
                    <th style="padding: 5px;">Brutto</th>
                    <th style="padding: 5px;">Liczba</th>
                    <th style="padding: 5px;">Suma</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($basket->basketItems as $position)
                <tr style="border-bottom: 1px solid #dfdfdf;">
                    <td style="padding: 5px; text-align: left; border-bottom: 1px solid #38900D;">
                        {{$position->name}}<br>

                        <span style="font-size: 12px; color: gray;">
                            {{$position->brand}}, {{$position->content}}
                        </span>

                        @if(!empty($position->expiration_date))
                            <div style="margin-top:6px; font-size:12px; color:#d71921; line-height:16px;">
                                Krótka data ważności:
                                <strong>{{ \Carbon\Carbon::parse($position->expiration_date)->format('d.m.Y') }}</strong>
                            </div>
                        @endif
                    </td>
                    <td style="padding: 5px; border-bottom: 1px solid #38900D;">{{number_format(floatval($position->priceNet), 2,',',' ')}} zł</td>
                    <td style="padding: 5px; border-bottom: 1px solid #38900D;">{{$position->vat_rate}}%</td>
                    <td style="padding: 5px; border-bottom: 1px solid #38900D;">{{number_format(floatval($position->valueGross), 2,',',' ')}} zł</td>
                    <td style="padding: 5px; border-bottom: 1px solid #38900D;">{{$position->quantity}}</td>
                    <td style="padding: 5px; border-bottom: 1px solid #38900D;">{{number_format(floatval($position->valueGross), 2,',',' ')}} zł</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" style="text-align: right"><p style="font-weight: 900; font-size: 16px;">Wartość zamówienia: </p></td>
                    <td  style="font-weight: 900; font-size: 16px;"><p>{{number_format(floatval($order->value_gross - $order->delivery_cost), 2,',',' ')}} zł</p></td>
                </tr>
            </tbody>
        </table>
        
        <br><br>
        
        <p style="font-size: 17px; font-weight: 900; width: 100%"><b>Dostawa:</b></p>
        <table style="border-collapse: separate; border-spacing: 0px 5px;  width: 100%;">
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;  width: 140px;">Metoda dostawy:</td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D; font-weight: 900; font-size: 16px;">{{$delivery->name}}</td>
            </tr>
            @if ($order->paczkomat_details != '' and $order->paczkomat_details != null)
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;  width: 140px;">Wybrany punkt dostawy:</td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D; font-weight: 900; font-size: 16px;">{{$order->paczkomat_details}}</td>
            </tr>
            @endif
        </table>
        <br>
        
        <p style="font-size: 17px; font-weight: 900; width: 100%"><b>Szczegóły płatności:</b></p>
        <table style="border-collapse: separate; border-spacing: 0px 5px;  width: 100%;">
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;  width: 140px;">Produkty:</td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D; font-weight: 900; font-size: 16px;">{{number_format(floatval($order->value_gross-$order->delivery_cost), 2,',',' ')}} zł</td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">Koszty wysyłki</td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">{{number_format(floatval($order->delivery_cost), 2,',',' ')}} zł</td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">Do zapłaty</td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D; font-weight: 900; font-size: 16px;">{{number_format(floatval($order->value_gross), 2,',',' ')}} zł</td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 4px 10px; background-color: #38900D; color: white; font-size: 14px; border-bottom: 1px solid #38900D;">Rodzaj płatności</td>
                <td style="padding: 4px 10px; border-bottom: 1px solid #38900D;">@if ($order->payment_type == 'przelewpaynow') przelew elektroniczny za pośrednictwem Paynow @elseif ( $order->payment_type == 'on') przelew tradycyjny @else {{$order->payment_type}} @endif</td>
            </tr>
        </table>
        <br>
    </div>
    <div style="padding: 10px; font-size: 15px;">
        <p>Pozdrawiamy<br>
            Zespół Apteki Wracam Do Zdrowia</p>
        <br>
        <br>
        <p style="font-size: 12px; font-weight: 100">Apteka Wracam Do Zdrowia<br>
        Plac Górnośląski 16<br>
        81-509 Gdynia<br>
        Osoba przyjmująca zamówienie: Iwona Florkowska<br>
        Numer telefonu: 585 731 741<br>
        Adres e-mail: apteka@wdoz.pl</p>

        <p style="font-size: 12px; font-weight: 100">Podmiotem prowadzącym Aptekę Wracam do Zdrowia, działającą pod adresem www.wracamdozdrowia.pl, jest spółka Wracam do zdrowia 8 spółka z ograniczoną odpowiedzialnością, adres: ul. Remusa 6, 81-574 Gdynia, wpisana do Rejestru Przedsiębiorców Krajowego Rejestru Sądowego prowadzonego przez Sąd Rejonowy w Gdańsku, Wydział Gospodarczy Krajowego Rejestru Sądowego pod numerem KRS: 0000674624, posiadająca REGON: 19212264200000, NIP: 5932265550, kapitał zakładowy 5.000,00 zł, pokryty w całości.</p>

        <p style="font-size: 12px; font-weight: 100">Numer zezwolenia Pomorskiego Wojewódzkiego Inspektoratu Farmaceutycznego: 976/2016</p>
        
        <p style="font-size: 12px; font-weight: 100">Mają Państwo prawo odstąpić od niniejszej umowy w terminie 14 dni bez podania jakiejkolwiek przyczyny.</p>

        <p style="font-size: 12px; font-weight: 700">Produkty lecznicze, środki spożywcze specjalnego przeznaczenia żywieniowego i wyroby medyczne wydane z Apteki Internetowej nie podlegają zwrotowi, za wyjątkiem produktu leczniczego lub wyrobu medycznego zwracanego z powodu wady jakościowej, niewłaściwego ich wydania lub sfałszowania produktu leczniczego.</p>

        <p style="font-size: 12px; font-weight: 100">Więcej informacji w zakresie zamówień, zwrotów i reklamacji znajdą Państwo w Regulaminie oraz zakładce Reklamacje i zwroty.</p>

        <p style="font-size: 12px; font-weight: 100">Administratorem Państwa danych osobowych jest spółka Wracam do zdrowia 8 spółka z ograniczoną odpowiedzialnością, adres: ul. Remusa 6, 81-574 Gdynia, wpisana do Rejestru Przedsiębiorców Krajowego Rejestru Sądowego prowadzonego przez Sąd Rejonowy w Gdańsku, Wydział Gospodarczy Krajowego Rejestru Sądowego pod numerem KRS: 0000674624, posiadająca REGON: 19212264200000, NIP: 5932265550, kapitał zakładowy 5.000,00 zł, pokryty w całości. Więcej informacji w zakresie przetwarzania danych osobowych znajdą Państwo w <a href="https://esklep.wdoz.pl/podstrona/polityka-prywatnosci/"  style="display: inline; font-weight: 700">Polityce Prywatności</a> i <a href="https://esklep.wdoz.pl/podstrona/regulamin/" style="display: inline; font-weight: 700">Regulaminie</a>.</p>
    </div>
</div>