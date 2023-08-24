<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

class ContactoSender extends Controller{

    public function SendEmailContact(Request $request){
    //dd("Envia Mail");
        $data = array('from_user_name'=>$request->nombre,
                        'from_user_email'=>$request->email,
                        'message'=>$request->comment

                    );

            Mail::send('mailings.07-contacto',['data'=>$data],function($message) use ($data){

                $message->to(env('MAIL_TO_SEND_CONTACT'), $data['from_user_name'])

                    ->subject('Mensaje desde contacto');

                $message->from(env('MAIL_FROM_ADDRESS'), 'Juega con chokis');

            });



            return redirect()->route("gracias");

    }

}