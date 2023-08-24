<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\Code;
use App\User;
use App\Week;
use stdClass;
use App\Ticket;
use Carbon\Carbon;
use App\RedeemedCode;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\GameLogRepository;

class PageController extends Controller
{

    public function __construct(GameLogRepository $game_log){
        $this->gamelog = $game_log;
    }
    // Teaser
    public function teaser() {
        return view('pages.teaser');
    }

    // Fin promo
    public function fin_promo() {
        return view('pages.fin-promo');
    }

    //Home
    public function Home(Request $request)
    {
        /*$ganadores = 0;
        $weeks = Week::get();
        $week = Week::selection($request->week)->first();
        if($week){
            $week->users = User::get()->sortByDesc('points_week')->reject(function($values,$key){
                return $values->points_week <= 0; //remove users with 0 points
            });
            $ganadores = count($week->users);
        }*/

        return view('pages.home')->with("week",[])->with("weeks",[]);

    }

    // Iniciar y recupear
    public function iniciar() {
        return view('pages.iniciar-sesion');
    }
    public function recuperar() {
        return view('pages.recuperar-contrasena');
    }
    public function cambiar(Request $request) {
        return view('pages.cambiar-contrasena', ['token' => $request->token, 'email' => $request->email]);
    }
    public function actualizada() {
        return view('pages.contrasena-actualizada');
    }

    // Perfil
    public function profile(Request $request){
         $puntos_globales = $this->gamelog->get_points_global_by_user(Auth::user()->id);
        if(isset($request->week)){
            $user = Auth::user();
            $weeks = Week::all();
            $week_active = Week::find($request->week);
            $codigos_puntuacion = $this->gamelog->get_user_codes_by_week_id_with_points(Auth::user()->id,$week_active->id);
            foreach ($weeks as $week) {
                if($week->id == $request->week){
                    $week->status = 1;
                }else{
                    $week->status = 0;
                }
            }

            //dd($codigos_puntuacion);
        }else{
            $user = Auth::user();
            $weeks = Week::all();
            $week_active = Week::where('status','=',1)->first();
            $codigos_puntuacion = $this->gamelog->get_user_codes_by_week_id_with_points(Auth::user()->id,$week_active->id);

            //dd($codigos_puntuacion);
        }


        return view('pages.perfil', compact('weeks','codigos_puntuacion', 'puntos_globales','week_active'));
    }
    // Registro
    public function registro() {
        return view('pages.registro');
    }
    public function registro_exitoso() {
        return view('pages.registro-exitoso');
    }
    public function valida() {
        return view('pages.valida-tu-correo');
    }

    // Ranking
    public function ranking_diario() {
        return view('pages.ranking-diario');
    }
    public function ranking_Weekl(Request $request){
        $game = new GameLogRepository();
        $users = User::get();
        $weeks = Week::get();
        $week = Week::active()->first() ?? new \stdClass;
        if($request->week){
            $week = Week::where('id',$request->week)->first() ?? new \stdClass;
        }
        foreach($users as &$u){
            $u->points_global = $game->get_points_global_by_user($u->id);
            $u->points_week = $game->get_user_codes_by_week_id_with_points($u->id,$week->id)->sum('total_score');
        }
        $users = $users->reject(function($v){ return $v->points_week < 1; });
        $users = $users->sortByDesc('points_week');

        return view('pages.ranking-semanal',compact('users', 'weeks','week'));
    }
    public function ranking_global() {
        $game = new GameLogRepository();
        $users = User::get();
        foreach($users as &$u){
            $u->points_global = $game->get_points_global_by_user($u->id);
            // $u->points_week = $game->get_user_codes_by_week_id_with_points($u->id,$week->id)->sum('total_score');
        }
        $users = $users->reject(function($v){ return $v->points_global < 1; });
        $users = $users->sortByDesc('points_global');

        return view('pages.ranking-global', compact('users'));
    }
    // Ganadores
    public function ganadores() {
        return view('pages.ganadores');
    }

    // Contacto
    public function contacto() {
        return view('pages.contacto');
    }
    public function gracias() {
        return view('pages.gracias');
    }

    // Legal
    public function aviso() {
        return view('pages.aviso');
    }
    public function terminos() {
        return view('pages.terminos');
    }
    public function faqs() {
        return view('pages.faqs');
    }

    // Juego
    public function whatsappGame(Request $request)
    {
        $code = Code::where('hash', $request->hash)->first();
        if(!$code) abort(404, 'Enlace inválido.');

        if($code && $code->status == 1) abort(404, 'Enlace inválido, este enlace ya fue utilizado.');

        Auth::loginUsingId($code->user_id);

        return response( redirect()->route('juego') )
                ->cookie('codigo_participante', $code->code, 60 * 12 )->cookie('permission', true);
    }
    public function registrar_codigo(Request $request){
        return view('pages.registrar-codigo')->with("message",$request->message);
    }
    public function juego(Request $request)
    {
        if(!$request->hasCookie('codigo_participante') || !$request->hasCookie('permission')){
            return redirect()->route('registrar-codigo');
        }

        if( UserCode::where('user_id', Auth::user()->id)->where('code', Cookie::get('codigo_participante') )->first()
         && Cookie::get('permission') != true){
            Cookie::queue(Cookie::forget('codigo_participante'));
            Cookie::queue(Cookie::forget('permission'));
            return redirect()->route('registrar-codigo');
        }

        $code = Code::where('code', Cookie::get('codigo_participante'))->first();
        if($code){
            $code->status = 1;
            $code->save();
        }

        Cookie::queue(Cookie::forget('permission'));

        return view('pages.juego');
    }
    // Cuano no lleva juego
    public function info_registrada() {
        return view('pages.informacion-registrada');
    }
}
