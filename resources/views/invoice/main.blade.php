<?php
use Rmunate\Utilities\SpellNumber;

setlocale(LC_NUMERIC, 'pl_PL.UTF-8'); // commas instead of dots
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Faktura {{$invoice->name}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .wrapper {}
        .column {float: left;}
        .clear {clear: both;}
        body {
            font-size: 0.3cm;
            font-family: DejaVu Sans, sans-serif;
            /*font-family: Helvetica, sans-serif;*/

        }


        div {
            width: 100%;
        }
        .center {
            text-align: center;
        }
        .money {
            text-align: right;
        }
        .half {width: 50%}
        table {width: 100%}
        table.date-class>tr {
            min-height: 10cm;
        }
        hr {
            color: #ccc;
        }
        .tiny {
            width: 0.5cm
        }
        .short {
            width: 1cm;
        }
        .price {
            width: 2.6cm;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .footer {
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="column" style="width: 30%">
            <img src="{{storage_path('/app/public/logo.jpg')}}" style="width: 4cm;">
        </div>
        <div class="column" style="width: 70%">

            <div class="center">
                <b> {{$type}}</b>
                <br>
                <br>
                Faktura <b>{{$invoice['name']}}</b>
            </div>
            <table style="border: 0" class="date-class">
                <br>
                <tr style="border: 0">
                    <td style="border: 0" class="half">Data wystawienia: {{$invoice['issue_date']}}</td>
                    <td style="border: 0" class="half">Data sprzedaży: {{$invoice['issue_date']}}</td>
                </tr>
                <tr style="border: 0">
                    <td style="border: 0" class="half">Termin płatności: {{$invoice['due_date']}}</td>
                    <td style="border: 0" class="half">Metoda płatności: {{ $invoice['payment_method'] == 'cash' ? 'gotówka' : 'przelew' }}</td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
    </div>
    <hr style="margin-top: 0.5cm; margin-bottom: 0.3cm;">
    <div class="wrapper">
        <div class="column half">
            <b>Sprzedawca</b>
            <br>
            @foreach($info as $label)
                {{ $label }}<br>
            @endforeach
        </div>
        <div class="column half">
            <b>Odbiorca</b>
            <br>
            {{$client->name}}
            <br>
            {{$client->address_line_1}} <br>
            {{$client->address_line_2}} <br>
            NIP {{$client->NIP}}

        </div>
        <div class="clear" style="margin-top: 0.5cm; margin-bottom: 0.5cm"></div>
    </div>

    <table>
        <tr>
            <th>Lp.</th>
            <th>Nazwa</th>
            <th>Jedn.</th>
            <th>Ilość</th>
            <th>Cena netto</th>
            <th>Stawka</th>
            <th>Wartość netto</th>
            <th>Wartość brutto</th>
        </tr>
        @foreach($fields as $index=>$field)
            <tr>
                <td class="tiny money">{{$index + 1}}</td>
                <td style="padding-left: 0.15cm">{{$field["product_name"]}}</td>
                <td class="tiny">szt.</td>
                <td class="short money">{{$field['amount']}}</td>
                <td class="price money">{{sprintf("%.2f", $field['unit_price']/100)}}</td>
                <td class="money tiny">{{$field['vat']}}%</td>
                <td class="price money">{{sprintf('%.2f', $field->net/100)}}</td>
                <td class="price money">{{sprintf('%.2f', $field->gross/100)}}</td>
            </tr>
        @endforeach
    </table>
    <br>
    <div class="wrapper">
        <div class="column half">
            <table>
                <tr>
                    <th>Stawka VAT</th>
                    <th>Wartość netto</th>
                    <th>Wartość podatku</th>
                    <th>Wartość Brutto</th>
                </tr>
                @foreach($invoice->taxLevels() as $level => $amount)
                    <tr>
                        <td class="money">{{$level}}%</td>
                        <td class="money">{{sprintf("%.2f", ($amount['net'])/100)}}</td>
                        <td class="money">{{sprintf("%.2f", ($amount['gross'] - $amount['net'])/100)}}</td>
                        <td class="money">{{sprintf("%.2f", ($amount['gross'])/100)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Razem</td>
                    <td class="money">{{sprintf("%.2f", $invoice->netPrice()/100)}}</td>
                    <td class="money">{{sprintf("%.2f", $invoice->tax()/100)}}</td>
                    <th class="money">{{sprintf("%.2f", $invoice->grossPrice()/100)}}</th>
                </tr>
            </table>
        </div>
        <div class="column half" style="text-align: right;">
            Do zapłaty <h2 style="display: inline">{{sprintf("%.2f", $invoice->grossPrice()/100)}} PLN</h2>

            <div style="padding: 1cm; margin-left: -1cm; margin-top: -0.5cm;">
                Słownie:
                {{SpellNumber::value(
                    $invoice->grossPrice()/100
                )->locale('pl')->currency('złotych')->fraction('groszy')->toMoney()}}
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="wrapper footer" style="margin-top: 2cm">
        <div class="column half center">
            {{$invoice->issuer}}<br>
            imię i nazwisko osoby uprawnionej
            <br>
            do wystawienia faktury
        </div>
        <div class="column half center">
            <br>
            imię i nazwisko osoby uprawnionej
            <br>
            do odbioru faktury
        </div>
        <div class="clear"></div>
    </div>


</body>
</html>
