<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semana extends Model
{
    //
    protected $table = 'semanas';

    /**Metodo que obtiene los ganadores */

    // public function Winners(){
    //     return $this->hasMany(Ganador::class,'week_id','id');
    // }

    public function Tickets (){
        return $this->hasMany(Ticket::class,'weekId','id');
    }
    
}
