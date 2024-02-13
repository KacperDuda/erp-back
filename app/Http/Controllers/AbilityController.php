<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbilityController extends Controller
{
    public function list(): array {
        return [
            //
            'product:all',
            'product:viewAny',
            'product:modify',
            //
            'pricelist:all',
            'pricelist:viewAny',
            'pricelist:modify',
            // soon to delete becaue priceList is enough
            'pricelistelement:all',
            'pricelistelement:viewAny',
            'pricelistelement:modify',
            //
            'client:all',
            'client:viewAny',
            'client:modify',
            //
            'entry:viewAny',
            'entry:limited', // for workers to have up to 7 day history access
            'entry:modify',
            'entry:all',
            // invoice and invoice_fields
            'invoice:viewAny',
            'invoice:view',
            'invoice:modify',
            'invoice:all',
        ];
    }
}
