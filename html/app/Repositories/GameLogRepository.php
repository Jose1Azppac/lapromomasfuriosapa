<?php

namespace App\Repositories;
use App\Models\GameLog;
use App\Models\badUserReport;
use App\Models\UserCode;
use App\Week;
use Carbon\Carbon;
use DB;
use Auth;
use Session;

class GameLogRepository{

    public function post_actividad($code){
        $game_log = new GameLog;
        try {
            $game_log->code = $code;
            $game_log->save();
            return 'success';
        } catch (\Throwable $th) {
            return 'error';
        }
    }

    public function get_score($code){

        $scores = GameLog::where('code', $code)
            ->orderBy('created_at')
            ->get();

            
        if ($scores->count() >= 2){
            //? *********** Tabla de puntaje ***********
            $data = [];
            for ($i = 0; $i < 91; $i++) {
                $duration = 30;
                $score = 120;
                $data[] = ['duration' => $duration + $i, 'score' => $score - $i];
            }
            //? *********** Tabla de puntaje ***********
            //* Obtiene segundos totales
            $start = Carbon::parse($scores->first()->created_at);
            $end = Carbon::parse($scores->last()->created_at);
            $durationInSeconds = $start->diffInSeconds($end);
            $score = 0;
            $found = false;
            //* Obtiene segundos totales

            //? Si tardó menos del tiempo minimo
            //? asigna la puntuacion mas alta
            if($durationInSeconds < 30){$score = 120;}
            else{
                // ? Busca el valor dentro de la lista $data columna duration
                foreach ($data as $current_data) {
                    if ($current_data['duration'] == $durationInSeconds) {
                        $score = $current_data['score'];
                        $found = true;
                        break;
                    }
                }
                //! Si no encontro el tiempo, tardo mas del limite 
                //! y se asigna la puntuacion más baja
                if(!$found){$score = 30;}
            }
            $response = $score;
        }else{
            $response = 0;
        }

        return $response;
    }

    public function get_total_score($code){
        $scored = GameLog::where('code', $code)->get();
        $total = count($scored) == 0 ? 5 : count($scored) *10;
        return $total;
    }

    public function post_cheat_detected($code, $action){
        $new_report = new badUserReport;
        try {
            $new_report->code   = $code;
            $new_report->action = $action;
            $new_report->save();
            return 'success';
        } catch (\Throwable $th) {
            return 'error';
        }
    }

    public function curl_code_validate($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        
        $err = curl_error($ch);  
        
        curl_close ($ch);
        return $response;
    }

    public function post_user_code($user, $code, $producto){
        $user_code = new UserCode;
        $week = new Week;
        try {
            $user_code->user_id = $user;
            $user_code->week_id = $week->GetActiveWeek();
            $user_code->code    = $code;
            $user_code->producto    = $producto;
            $user_code->save();
            return 'success';
        } catch (\Throwable $th) {
            return 'error';
        }
    }

    public function get_user_codes_by_week_id_with_points($user_id, $week_id){
        // Se obtiene todos los codigos del user
        $user_codes = UserCode::where('user_id', $user_id)
                                ->where('week_id', $week_id)
                                ->get();
        // Se calcula el score por cada codigo del user
        $puntos_globales = 0;                               
        foreach ($user_codes as $key => $user_code) {
            $user_code->total_score = $this->get_total_score($user_code->code);
            $puntos_globales+=$user_code->total_score;
            $dt = Carbon::parse($user_code->created_at);
            $user_code->date = $dt->day;
            $user_code->month = ucfirst( $dt->locale('es')->shortMonthName );
            $user_code->year = $dt->year;
            $user_code->hour = $dt->isoFormat('h:mm A');

        }
        return $user_codes;
    }


    public function get_points_global_by_user($user_id){
        // Se obtiene todos los codigos del user
        $user_codes = UserCode::where('user_id', $user_id)->get();
        // Se calcula el score por cada codigo del user
        $puntos_globales = 0;                               
        foreach ($user_codes as $key => $user_code) {
            $user_code->total_score = $this->get_total_score($user_code->code);
            $puntos_globales+=$user_code->total_score;  
        }
        return $puntos_globales;
    }

}