<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property PriceList $priceList
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_list_id',
        'name',
        'email',//email:
        'nickname',
        'address_line_1',
        'address_line_2',
        'additional_info',
        'NIP',
        'is_company',
        'comment',
    ];

    public function priceList(): BelongsTo
    {
        return $this->belongsTo(PriceList::class);
    }

    // shortcut
    public function priceOf(Product|int $product): int {
        return $this->priceList->priceOf($product);
    }

    public function vatOf(Product|int $product): float
    {
        return $this->priceList->vatOf($product);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }
}
