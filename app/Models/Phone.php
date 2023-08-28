<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Phone extends Model
{
    use HasFactory, HasShortflakePrimary;

    protected $fillable = ['phone', 'user_id'];
}
