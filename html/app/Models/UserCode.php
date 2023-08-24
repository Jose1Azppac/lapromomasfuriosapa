<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    //
     protected $table = 'user_codes';
     protected $fillable = [
        'user_id',
        'week_id',
        'code'
    ];
}
