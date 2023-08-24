<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $fillable = [
        'user_id',
        'week_id',
        'code',
        'hash',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($code) {
            $week = Week::active()->first();
            $code->week_id = $week ? $week->id : 0;
        });
    }
}
