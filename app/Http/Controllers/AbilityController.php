<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbilityController extends Controller
{
    public function list(): array {
        return [
            'product:all',
            'product:viewAny',
            'product:modify',
        ];
    }
}
