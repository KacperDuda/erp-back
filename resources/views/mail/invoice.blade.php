<?php

use App\Services\Invoices\PDFCreator;

setlocale(LC_NUMERIC, 'pl_PL.UTF-8'); // commas instead of dots
?>

    <!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktura {{$invoice->name}}</title>
    @vite('resources/css/app.css')
    <style>
        .wrapper {
            width: 500px;
            margin: 20px auto;
            font-family: "DejaVu Sans", serif;
        }
    </style>
</head>
<body>
<div class="wrapper border-round-xl	border-2 border-solid">
    <div class="p-3 text-center">
        <span class="font-bold text-3xl">Pralnia Krystyna</span>
        <br>
        <span>Sprawdź fakturę w załączniku</span>
    </div>
    <hr class="m-0" style="border-color: #000;">
    <div class="p-3">
        Dzień dobry,<br>
        przesyłamy fakturę w załączniku. <br>
        Poniżej przedstawiamy jej podsumowanie: <br>
        <ul>
            <li>Numer faktury: <b>{{$invoice->name}}</b></li>
            <li>Data wystawienia: {{$invoice->issue_date}}</li>
            <li>Termin płatności: {{$invoice->due_date}}</li>
            <li>Kwota: <b>{{sprintf('%.2f', $invoice->grossPrice()/100)}}zł</b></li>
        </ul>
    </div>

    <hr class="m-0" style="border-color: #000">
    <div class="p-3">
        @foreach(PDFCreator::$info as $data)
            {{$data}}<br>
        @endforeach
    </div>
</div>
</body>
</html>
