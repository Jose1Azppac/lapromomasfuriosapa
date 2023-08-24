<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Helper\Mongo;
use App\Helper\Helper;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use App\Repositories\GameLogRepository;
use Illuminate\Database\Schema\Blueprint;

class FunctionsController extends Controller
{
    public function __construct(GameLogRepository $game_log){
        $this->gamelog = $game_log;
    }

    public function validar_codigo(Request $request){
        $CodebyInDay = UserCode::where('user_id',Auth::user()->id)
                        ->whereDate('created_at', '=', Carbon::today()->toDateString())
                        ->get()->count();
        $producto = $request->producto;
        if($CodebyInDay < 15 || Helper::validateParticipationUser(Auth::user()->id, $producto)){
            if($producto == 'snacks_salados' || $producto == 'Tortix'){
                // Revisa si se envio el dato
                if ($request->filled('codigo')) {
                    // Se limpia el input y envia el codigo a revisión
                    $codigo = strip_tags($request->input('codigo'));
                    /* Devuelve status del 0 al 2 donde:
                    Status code = 0 -> El codigo no existe
                    Status code = 1 -> El codigo existe y se ha marcado como usado
                    Status code = 2 -> El codigo existe pero ya fue usado
                    */
                    $status = (int) Mongo::redeemCode(Auth::user()->id, $codigo)->status_redimed;
                    /* Flujo regular */
                    switch ($status) {
                        case 1:
                            $minutos            = 60;
                            $horas              = 12;
                            $tiempo_de_validez  = $minutos * $horas;
                            $cookie = cookie('codigo_participante', $request->input('codigo'), $tiempo_de_validez);
                            // Crea registro de cual usuario reclamó cual código
                            $this->gamelog->post_user_code(Auth::user()->id, $codigo, $producto);
                            $cookie_permission = cookie('permission', true, $tiempo_de_validez);
                            // return redirect()->route('page.juega')->withCookie($cookie);
                            // echo $codigo;
                            $response = array(
                                'status' => 'success',
                                'code' => 1
                            );
                            return response()->json($response, 200)->withCookie($cookie)->withCookie($cookie_permission);
                            break;

                        case 2:
                            $response = array(
                                'status' => 'error',
                                'code' => 2
                            );
                            return response()->json($response, 200);
                            break;

                        default:
                        $response = array(
                            'status' => 'error',
                            'code' => 0
                        );
                        return response()->json($response, 200);
                            break;
                    }
                }
            }else {
                if ($request->filled('codigo')) {
                    // Se limpia el input y envia el codigo a revisión
                    $codigo = strip_tags($request->input('codigo'));
                    $minutos            = 60;
                    $horas              = 12;
                    $tiempo_de_validez  = $minutos * $horas;
                    $cookie = cookie('codigo_participante', $request->input('codigo'), $tiempo_de_validez);
                    $cookie_permission = cookie('permission', true, $tiempo_de_validez);
                    // Crea registro de cual usuario reclamó cual código
                    $this->gamelog->post_user_code(Auth::user()->id, $codigo,$producto);
                    // return redirect()->route('page.juega')->withCookie($cookie);
                    // echo $codigo;
                    $response = array(
                        'status' => 'success',
                        'code' => 1
                    );
                    return response()->json($response, 200)->withCookie($cookie)->withCookie($cookie_permission);
                }

            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 3
            );
            return response()->json($response, 200);
        }

    }
    public function memorama_post(Request $request){
        // Validar si la petición se realizó con ajax
        if($request->ajax()){
            // Validar si viene con la cookie
            if($request->hasCookie('codigo_participante')){
                //? Si tiene cookie...
                if($request->input('action') == 'init'){
                    //* grabar en DB
                    $status = $this->gamelog->post_actividad($request->cookie('codigo_participante'));
                    $response = array(
                        'status' => $status
                    );
                    return response()->json($response, 200);
                }else{
                    //* retorna puntaje
                    $this->gamelog->post_actividad($request->cookie('codigo_participante'));
                    $puntaje = $this->gamelog->get_score($request->cookie('codigo_participante'));

                    $response = array(
                        'status' => 'success',
                        'puntaje' => $puntaje
                    );
                    // ! Destruir la cookie
                    $cookie = Cookie::forget('codigo_participante');

                    return response()->json($response, 200)->withCookie($cookie);
                }
            }
        }
    }
    public function cheater_post(Request $request){
        if($request->ajax()){
            if($request->hasCookie('codigo_participante')){
                $code   = $request->cookie('codigo_participante');
                $action = $request->input('action');
                $status = $this->gamelog->post_cheat_detected($code,$action);
                $response = array('status' => $status);
                // ! Destruir la cookie
                $cookie = Cookie::forget('codigo_participante');
                return response()->json($response, 200)->withCookie($cookie);
            }
        }
    }
    public function memorama_post_nuevo_par(Request $request){
        // Validar si la petición se realizó con ajax
        if($request->ajax()){
            // Validar si viene con la cookie
            if($request->hasCookie('codigo_participante')){
                //? Si tiene cookie...
                //* grabar en DB
                $status = $this->gamelog->post_actividad($request->cookie('codigo_participante'));
                $response = array(
                    'status' => $status
                );
                return response()->json($response, 200);
            }
        }
    }
    public function memorama_get_total_score(Request $request){
        // Validar si la petición se realizó con ajax
        if($request->ajax()){
            // Validar si viene con la cookie
            if($request->hasCookie('codigo_participante')){
                //? Si tiene cookie...
                //* retorna puntaje
                $puntaje = $this->gamelog->get_total_score($request->cookie('codigo_participante'));

                $response = array(
                    'status' => 'success',
                    'puntaje' => $puntaje
                );
                // ! Destruir la cookie
                $cookie = Cookie::forget('codigo_participante');

                return response()->json($response, 200)->withCookie($cookie);

            }
        }
    }
}
