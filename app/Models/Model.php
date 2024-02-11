<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @method static findOrFail(int $id)
 * @method static create()
 */
class Model extends BaseModel
{
    use HasFactory;
}
