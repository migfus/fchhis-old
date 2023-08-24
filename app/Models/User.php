<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
      'name',
      'email',
      'password',
      'username',
      'avatar',
      'plan_id',
      'notify_mobile',
      'role',
      'OR',
      'pay_type_id',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
      'password',
      'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
  ];

  public function info() {
    return $this->hasOne(Info::class);
  }

  public function plan() {
    return $this->belongsTo(Plan::class, 'plan_id', 'id');
  }

  public function agent_users() {
    return $this->hasMany(info::class, 'agent_id');
  }

  public function agent_transactions() {
    return $this->hasMany(Transaction::class, 'agent_id', 'id');
  }

  public function client_transactions() {
    return $this->hasMany(Transaction::class, 'client_id', 'id');
  }

  public function pay_type() {
    return $this->belongsTo(PayType::class, 'pay_type_id');
  }


}
