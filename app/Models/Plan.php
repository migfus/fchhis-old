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
    ];

    public function infos() {
        return $this->hasMany(Info::class);
    }

    public function planDetails() {
        return $this->hasMany(PlanDetails::class);
    }
}
