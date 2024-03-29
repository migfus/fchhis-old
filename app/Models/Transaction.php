<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Transaction extends Model
{
    use HasFactory, HasShortflakePrimary;

    protected $fillable = [
        'client_id',
        'staff_id',
        'client_id',
        'pay_type_id',
        'plan_details_id',
        'amount',
        'agent_id',
        'or',
    ];

    public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function staff() {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function agent() {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function plan_details() {
        return $this->belongsTo(PlanDetails::class, 'plan_details_id');
    }

    public function pay_type() {
        return $this->belongsTo(PayType::class, 'pay_type_id');
    }

  // public function self_transactions() {
  //   return $this->hasMany(Transactions::class, '')
  // }
}
