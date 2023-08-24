<?php
 
namespace App\Http\Controllers;
 
use File;
use Mail;
use Image;
use App\User;
use App\Semana;
use App\Ticket;
use Carbon\Carbon;
use App\RedeemedCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
 
class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function register(Request $request){
        $newPass = Hash::make($request->passwordform);
        $birthDay = strtotime($request->dayAgeform);
        $userBirthDay = date("Y/m/d",$birthDay);
        $age = Carbon::parse($userBirthDay)->diff(Carbon::now())->y;
        try {
            $newUser = new User();
            $newUser->name = $request->nombreform;
            $newUser->last_name = $request->apellidoform;
            $newUser->official_id_num = $request->officialnumform;
            $newUser->email = $request->emailform;
            $newUser->password = $newPass;
            $newUser->phone = $request->phoneform;
            $newUser->phone_operator = $request->phoneoparatorform;
            $newUser->city = $request->cityform;
            $newUser->postalCode = "00000";
            $newUser->neighborhood = "none";
            $newUser->birthday = $userBirthDay;
            $newUser->age = $age;
            $newUser->gender = "no_decirlo";
            $newUser->avatar = "no_decirlo";
            $newUser->email_consent = 1;
            $newUser->whatsapp_consent = 1;
            $newUser->save();
            //$this->SaveSalesForce($newUser->id);
            $this->sendMailRegistro($newUser);
        }catch (\Illuminate\Database\QueryException $e){
            dd($e);
            return 2; //retorno de error de mail duplicado
        }
            return 1;
    }    

    /**
     * 
     * Metodo que envia el m ail de registro para confirmacion del correo del usaurio
     */
    private function sendMailRegistro(User $userData){
        $cryptNumber = 77541;
        $cryptId = $userData->id * $cryptNumber;
        $data = array('mail_to'=>$userData->email,
                    'completo'=>$userData->name." ".$userData->last_name,
                    'usr_id'=>$userData->id,
                    'url_to_verify'=>route('verify_user_mail', ['uid'=>$cryptId])
        );
        Mail::send('mailings.01-registro',['data'=>$data],function($message) use ($data){
            $message->to($data['mail_to'], $data['completo'])
                // ->cc(['luis@torodigital.com.mx'])
                ->subject('Completa tu registro en Frito LAY La promo mas furiosa! 👏');
            $message->from(env('MAIL_FROM_ADDRESS'), 'La promo mas furiosa');
        });
        
    }

    /**
     * Metodo que valida el mail del usuario para completar el registro
     */
    public function VerifyMail(Request $request){

        $cryptNumber = 77541;
        $userID = ((int)$request->uid) / ((int)$cryptNumber);
        //dd($userID);
        $userToValidate = User::findOrFail($userID);
        $userToValidate->email_is_verifired = 1;
        $userToValidate->save();

        /**Logueamos al usuario */
        Auth::loginUsingId($userToValidate->id);
        return view("pages.registro-exitoso");    
    }


    public function authenticate(Request $request){
        $userTologin = User::where('email',$request->emaillogin)->where('status',1)->first();
        if($userTologin){
            /**
             * Validamos si el usaario ya valido su email
             */
            if($userTologin->email_is_verifired==1){
                /**VAlidamos el PAssword del ussurio */
                $passWordDB = $userTologin->password;
                if(Hash::check($request->passwordmail, $passWordDB)){
                    $dataToReturn = $userTologin;
                    Auth::loginUsingId($userTologin->id);
                    return 1; //usuario logueado
                }else{
                    /**
                     * Password incorrecto
                     */
                    return 3; //error en el password
                }

            }else{
                /**
                 * El email no ha sido validado por el usaurio
                 */
                return 4; //error mail no confirmado por el usuario
            }
        }else{
            /**
             * Correo incorrecto
             */
            return 2;//error_usuario_no_existe
        }
    }


    public function RetriveTicket(Request $request){
        /**
         * Primero validamos el numero de tickets enviados por dia del usaurio
         */
        $now = Carbon::now();
        $ticketsInDay = RedeemedCode::where('id_user',Auth::user()->id)
                                ->whereDate('created_at', '=', Carbon::today()->toDateString())
                                ->get()
                                ->count();
        if($ticketsInDay < 10){
            /**
             * El usaurio si puede subir ticket el dia de hoy por que aun no llega a el numero maximo
             */
            //$imageTicket = $this->saveImage($request, 'ticket');
            $userID = Auth::user();
            $weekToSave = $this->GetCurrentWeek();
            $newTicket = new RedeemedCode();
            $newTicket->id_user = $userID->id;
            $newTicket->id_week = $weekToSave->id;
            $newTicket->id_api_code = 1;
            $newTicket->code_remided = $request->lote_code;
            $newTicket->imagen_lote = '';
            $newTicket->point = 10;
            $newTicket->save();

            return redirect()->route('registrar-codigo', ['message'=>1]);
        }else{
            /**
             * El usuario no puede subir mas tickets el dia de hoy
             */
            return redirect()->route('registrar-codigo', ['message'=>2]);
        }
    }
    /**
     * Metodo que guarda la imagen del ticket en el disco local
     */
    private function saveImage(Request $imageRequest, $imageFieldName){
        $timeNow = time();
        $imageName = "ticket_".$timeNow.".".$imageRequest->file($imageFieldName)->getClientOriginalExtension();
        $this->resizeImage($imageRequest, $timeNow,'recipes_tickets',$imageFieldName);
        $pathBd = "/recipes_tickets/".$imageName; 
        return $pathBd;
    }
    /**
     * Metodo que re escala la imagen a 1200 PX
     */
    private function resizeImage(Request $imageRequest, $time, $folder, $imageFieldName){

        $imageName = "ticket_".$time.".".$imageRequest->file($imageFieldName)->getClientOriginalExtension();       

        /**Se crea el directorio en caso de que no exista */
        $path = storage_path('app/public/'.$folder);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        
        /*Hacemos pequeña la image*/
        $destinationPath = storage_path('app/public/'.$folder);
        // $destinationPath = public_path($folder);
        $bigImage = $imageRequest->file($imageFieldName);
        $img = Image::make($bigImage->path());
        $img->resize(1200, 1200, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }
    private function GetCurrentWeek(){
        $toDay = Carbon::today()->toDateString();
        $currentWeek = "";
        $allWeeks = Semana::all();
        foreach($allWeeks as $week){
            if($toDay >= $week->inicio && $toDay<=$week->final ){
                $currentWeek = $week;
            }
        }
        if($currentWeek==""){
            $currentWeek = Semana::latest()->first();
        }
        
        return $currentWeek;
    }

    
}