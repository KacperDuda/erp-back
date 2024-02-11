<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $amount
 * @property int $unit_price
 * @property Carbon|mixed $created_at
 * @property Carbon|mixed $updated_at
 */
class Entry extends Model
{
    use HasFactory;

    public static function getLimitDate(): Carbon
    {
        return now()->subDays(8)->setHour(0)->setMinute(0)->setSecond(0);
    }

    protected $fillable = [
        'amount',
        'comment',
        'product_id',
        'client_id',
        'color',
        'user_id',
        'unit_price',
        'vat',
        'left',
        'posting_date'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
