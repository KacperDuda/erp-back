<?php

namespace App\Observers;

use App\Models\PriceList;

class PriceListObserver
{

    /**
     * Handle the PriceList "updating" event.
     */
    public function updating(PriceList $priceList): void
    {
        $priceList->preventCycle();
    }
}
