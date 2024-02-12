<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;


/**
 * @property integer $net
 * @property integer $vat
 * @property integer $gross
 */
class InvoiceField extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_name',
        'amount',
        'unit_price',
        'vat',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function net(): Attribute
    {
        return Attribute::make(get: function (mixed $value, array $attr) {
            return $attr['amount'] * $attr['unit_price'];
        });
    }

    public function gross(): Attribute {
        return Attribute::make(get: function (mixed $value, array $attr) {
            return round($attr['net'] * (1.0 + ($attr['vat'])/100), 0);
        });
    }

    public function tax(): int
    {
        return $this->gross - $this->net;
    }
}
