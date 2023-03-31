<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
      'lastName', 'firstName', 'midName', 'extName', 'bday', 'bplace_id',
      'sex', 'address_id', 'address'
    ];
}
