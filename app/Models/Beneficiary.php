<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
      'person_id',
      'lastName',
      'firstName',
      'midName',
      'extName',
      'bday',
    ];
}
