<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;

/**
 * @property Collection<InvoiceField> $invoiceFields
 */
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'serial',
        'payment_method',
        'issue_date',
        'issuer',
        'due_date',
        'is_paid',
        'is_sent',
        'client_id',
    ];

    public function invoiceFields(): HasMany
    {
        return $this->hasMany(InvoiceField::class);
    }

    public function netPrice(): int {
        return $this->taxLevels()->sum('net');
    }

    public function grossPrice(): int
    {
        return $this->taxLevels()->sum('gross');
    }

    public function taxLevels(): BaseCollection
    {
        return $this->invoiceFields->groupBy('vat')->map(function ($group, $key) {
            $net = $group->sum('net');

            return collect([
                'net'=> $net,
                'gross' => round($net * (1.0 + ($key/100)))
            ]);
        });
    }

    public function tax(): int
    {
        return $this->grossPrice() - $this->netPrice();
    }
}
