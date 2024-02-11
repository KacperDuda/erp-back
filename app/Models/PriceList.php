<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function PHPUnit\Framework\throwException;


/**
 * @property mixed $id
 * @property double $multiplier
 */
class PriceList extends Model
{
    use HasFactory;

    protected $hidden = [
        'parent'
    ];

    protected $fillable = [
        'name',
        'parent_id',
        'multiplier'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PriceList::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(PriceList::class, 'parent_id');
    }

    /**
     * @throws \Exception
     */
    public function preventCycle($ids = []): void
    {
        // we go up the tree and check whether we
        // go back to the same place

        if(in_array($this->id, $ids)) {
            throw new \Exception('Cycle Detected in Tree');
        }
        $ids[] = $this->id;

        $this->parent?->preventCycle($ids);
    }

    public function priceListElements(): HasMany
    {
        return $this->hasMany(PriceListElement::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function priceOf(Product|int $product): int
    {
        if($product instanceof Product) {
            $product = $product->id;
        }

        // check for price list element first
        $price_list_element = $this->priceListElements->where('product_id', $product)->first();

        // if present, return it
        if($price_list_element) {
            return $price_list_element['price'];
        }

        // if there is a parent, check their price - recursive
        if($this->parent) {
            return round(($this->multiplier) * ($this->parent->priceOf($product)));
        }

        // if there is nothing, return 0
        return 0;
    }
}
