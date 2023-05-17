<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
      'created_by_user_id',
      'lastName',
      'firstName',
      'midName',
      'extName',
      'bday',
      'bplace_id',
      'sex',
      'address_id',
      'address',
      'mobile',
      'agent_id',
    ];

  // FIXME DEPRICATED NEW staff()
  public function user() {
    return $this->belongsTo(User::class, 'created_by_user_id');
  }

  // FIXME DEPRICATED NEW agent()
  public function referred() {
    return $this->belongsTo(User::class, 'agent_id');
  }

  public function agent() {
    return $this->belongsTo(User::class, 'agent_id');
  }

  public function staff() {
    return $this->belongsTo(User::class, 'created_by_user_id');
  }
}
