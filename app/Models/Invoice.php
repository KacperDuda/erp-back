<?php

namespace App\Models;

use App\Services\Invoices\PDFCreator;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Mail\Attachment;


/**
 * @property Collection<InvoiceField> $invoiceFields
 * @property integer $client_id
 */
class Invoice extends Model implements Attachable
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

    protected $appends = ['name'];

    public static function nextSerial(int $year): int {
        return 1 + (Invoice::where('year', $year)->orderBy('id', 'desc')->first()?->serial ?: 0);
    }

    public function name(): Attribute {
        return Attribute::make(get: function ($value, $attr) {
            return "F/".$attr['year']."/".
                sprintf("%03d",$attr['serial'])."/".
                sprintf("%02d", $attr['month']);
        });
    }

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

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
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


    public function toMailAttachment(): Attachment
    {
        return Attachment::fromData(
            fn() => PDFCreator::fromInvoice(
                $this,
                "Oryginał"
            )->output(),
            $this->name
        )->withMime('application/pdf');
    }
}
