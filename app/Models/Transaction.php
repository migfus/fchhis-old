<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  use HasFactory;

  protected $fillable = ['referral_id', 'client_id', 'plan_id', 'amount'];

  public function client() {
    return $this->belongsTo(User::class, 'client_id');
  }

  public function staff() {
    return $this->belongsTo(User::class, 'staff_id');
  }

  public function agent() {
    return $this->belongsTo(User::class, 'agent_id');
  }

  public function plan() {
    return $this->belongsTo(Plan::class);
  }
}
