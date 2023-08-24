<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $fillable = [
        'start',
        'end',
        'status'
    ];

    public function codes (){
        return $this->hasMany(Code::class);
    }

    public function scopeSelection($query,$week){
        return $week ? $query->where('id',$week) : $query->where('status',1);
    }

    public static function GetCurrentWeek(){
        $toDay = Carbon::today()->toDateString();
        $currentWeek = "";
        $allWeeks = Week::all();
        foreach($allWeeks as $week){
            if($toDay >= $week->inicio && $toDay<=$week->final ){
                $currentWeek = $week;
            }
        }
        if($currentWeek==""){
            $currentWeek = Week::latest()->first();
        }

        return $currentWeek;
    }

    public function GetActiveWeek(){
        return Week::where('status',1)->first()->id;
    }
    public function scopeActive($query){
        $query->where('status', 1);
    }

}
