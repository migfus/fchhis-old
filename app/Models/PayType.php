<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class PayType extends Model
{
    use HasFactory, HasShortflakePrimary;

    protected $fillable = ['name'];
}
