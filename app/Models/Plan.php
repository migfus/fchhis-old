<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Plan extends Model
{
    use HasFactory, HasShortflakePrimary;

    protected $fillable = [
            'name',
            'avatar',
            'age_start',
            'age_end',
            'desc',
            'contract_price',
            'spot_pay',
            'spot_service',
            'user_id',
            'annual',
            'semi_annual',
            'quarterly',
            'monthly'
    ];

    public function infos() {
        return $this->hasMany(Info::class);
    }
}
