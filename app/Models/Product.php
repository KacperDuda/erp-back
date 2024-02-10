<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname'
    ];


    /**
     * Return official name if nickname is not set
     * @return Attribute
     */
    public function nickname(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $value ?: $attributes['name'];
            }
        );
    }
}
