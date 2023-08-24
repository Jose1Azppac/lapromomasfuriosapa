<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\User;
use App\Week;
use App\Ticket;
use Carbon\Carbon;
use App\RedeemedCode;
use App\salesforce\Sender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Repositories\GameLogRepository;

class Site extends Controller
{
    //
    public function Home(Request $request){
         if(isset($request->week)){
        
        $weeks = Week::all();
        $semana_activa = Week::find($request->week);
        $dia_inicio = Carbon::parse($semana_activa->start);
        $dia_final= Carbon::parse($semana_activa->end);

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        $mes1 = $meses[($dia_inicio->format('n')) - 1];
        $mes2 = $meses[($dia_final->format('n')) - 1];

        foreach ($weeks as $week) {
            if($week->id == $request->week){
                $week->status = 1;
            }else{
                $week->status = 0;
            }
        }

        $ranking = '';
        }else{

            $weeks = Week::all();
            $semana_activa = Week::where('status','=','1')->first();
            $dia_inicio = Carbon::parse($semana_activa->start);
            $dia_final= Carbon::parse($semana_activa->end);
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $mes1 = $meses[($dia_inicio->format('n')) - 1];
            $mes2 = $meses[($dia_final->format('n')) - 1];
            $ranking = '';

        }
        
        $numavatar = 0;
        return view('pages.home',compact('ranking','weeks','dia_inicio','dia_final','mes1','mes2'));
    }

    public function HomeALternativo(Request $request){
        return view('pages.home-alternativo');
    }

    public function Perfil(Request $request){
        $user = Auth::user();
        $codigos_puntuacion = $this->get_user_codes_by_week_id_with_points(Auth::user()->id,$week_active);
        dd($codigos_puntuacion);
        $week_active = Week::selection($request->week)->first() ?? -1;
        $weeks = Week::get();

        //$tickets = $user->tickets()->where('semana_id',$week_active->id)->where('status',1)->get();
        $points_global = 100;

        return view('site.pages.perfil',compact('user','codigos_puntuacion','week_active','weeks','points_global'));
    }
    
    public function EliminarCuentaUsuario(Request $request){
        $user = Auth::user();
        $user->status = 0;
        $user->update();
        
        $completo = Auth::user()->name;
        $email = Auth::user()->email;
        $data = array('mail_to'=>$email, 'completo'=>$completo);

        Mail::send('site.mailings.05-eliminado',['data'=>$data],function($message) use ($data){
            $message->to($data['mail_to'], $data['completo'])
                    ->subject('¡Tu cuenta ha sido eliminada! 🔫');
            $message->from(env('MAIL_FROM_ADDRESS'), 'Actitud de Verano');
        });
        
        Auth::logout();
        return response()->json(['value'=>'0']);
    }
    public function Gracias(Request $request){
        return view('site.pages.gracias');
    }

    public function Faqs(Request $request){
        return view('site.pages.faqs');
    }

    public function Terminos(Request $request){
        return view('site.pages.terminos');
    }

    public function Aviso(Request $request){
        return view('site.pages.aviso');
    }

    public function Contacto(Request $request){
        return view('site.pages.contacto');
    }

    public function Exitoso(Request $request){
        return view('site.pages.registro_exitoso');
    }

    public function Ganadores(Request $request){        
        return view('site.pages.ganadores');
    }
    public function Logout(Request $request){
        Auth::logout();
        return redirect()->route("home");
    }

    /**
     * Metodo para mostrar el juego
     */
    public function PlayTheGame(Request $request, $id){
        $correctID = $id/85635748;
        $ticketToEdit = Ticket::find($correctID);
        $ticketToEdit->user_play = 1;
        $ticketToEdit->save();
        
        return view('site.pages.game');
    }

    public function PruebaAPI (Request $request){
        $env_enviroment = ENV('APP_URL');
        $url_frag = explode("/", $env_enviroment);
        $url_api =  $url_frag[0].'//'. $url_frag[2].'/api/validate_code';
        
        $url = $url_api;

        
        // $url = 'https://stg-lat-juegaconchokis.pepmx.com/api/validate_code';
        $dataToSend = array("codigo"=>"123456",
                            "pais"=>"MX",
                            "user_id"=>5,
                            "_token"=>csrf_token());
        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'  ));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSend);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        
        $err = curl_error($ch);  
        
        curl_close ($ch);
        dd($response);
    }

    public function CreateImageSecurity(Request $request){

        $img1 = new \Imagick(storage_path('app/public/backCaptcha.jpg'));
        /*Se empieza a colocar las imagenes sobre el canva*/
        $draw = new \ImagickDraw();
        /*Color de fondo del canva*/
        $draw->setFillColor('#FFF600');
        $draw->setFont(public_path('/fonts/typo/Montreal-Heavy.ttf'));
        $draw->setStrokeAntialias(true);
        $draw->setTextAntialias(true);
        $draw->setTextAlignment(\Imagick::ALIGN_CENTER);

        $texto_val = Session::get("veryfy_code");
        $message = new \ImagickDraw();
        $message->setFillColor('#FDFDFD');
        $message->setStrokeAntialias(false);
        $message->setTextAntialias(false);
        $message->setTextAlignment(\Imagick::ALIGN_CENTER);

        $draw->setFontSize(35);
        /*Posicion de la frase*/
        $img1->annotateImage($draw,75,40,0,$texto_val);
        /*public path*/
        $saveImagePath = storage_path('app/public/captcha.jpg');

        header('Content-type: image/png');
        $img1->writeImage ($saveImagePath);
        return response()->file($saveImagePath);

    }

    /*Crea las provicias por PAIS con base en las nomenclaturas del archivo APP.js */

    public function PruebaEnv(){
        $dbselected =  \DB::statement('ALTER TABLE user_codes ADD imagen_lote VARCHAR(100) NOT NULL AFTER code_remided');
        return $dbselected;
    }

    public function Iniciar(Request $request){
        return view('site.pages.iniciar-sesion');
    }

    public function Registrate(Request $request){
        return view('site.pages.registrate');
    }

    public function RegisterSucces(Request $request){
        return view('site.pages.register-succes');
    }

    public function Registrar(Request $request){
        return view('site.pages.registrar-codigo')->with("message",$request->message);
    }

    public function Contractualizada(Request $request){
        return view('site.pages.contrasena-actualizada');
    }


}
