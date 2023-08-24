<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $fillable = [
      'created_by_user_id',
      'bday',
      'bplace_id',
      'sex',
      'address_id',
      'address',
      'mobile',
      'agent_id',
      'due_at',
      'fulfilled_at',
      'staff_id',
      'name',
      'pay_type_id',
      'plan_id',
      'client_id',
      'due_at',
      'or'
    ];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function agent() {
    return $this->belongsTo(User::class, 'agent_id');
  }

  public function agent_transactions() {
    return $this->hasMany(Transaction::class, 'agent_id');
  }

  public function agent_clients() {
    return $this->hasMany(User::class, 'agent_id');
  }

  public function staff() {
    return $this->belongsTo(User::class, 'staff_id');
  }

  public function plan() {
    return $this->belongsTo(Plan::class, 'plan_id');
  }

  public function pay_type() {
    return $this->belongsTo(PayType::class, 'pay_type_id');
  }

  public function client_transactions() {
    return $this->hasMany(Transaction::class, 'client_id');
  }

  public function phones() {
    return $this->hasMany(Phone::class);
  }
}
