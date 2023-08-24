<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Ticket;
use App\Semana;
use App\Week;
use App\User;
use Image;
use File;
use Auth;
use Mail; 
use DB;

class AdminCmsController extends Controller
{
    //
    public function LoginPage(Request $request){
        return view('site.admin.login_admin');
    }

    public function VerifyLoginAdmin(Request $request){
        $user = \DB::table('admins')
                        ->where('email', '=', $request->email)
                        ->where('password','=',md5($request->password))->first();
        if(! $user){
            return redirect('cms/login');
        }else{
            //$sesion_admin = Auth::guard('usuario')->loginUsingId($user->id);
            return redirect()->route('cms.dashboard');
        }
    }


    public function dashboard(){
        return view('site.admin.dashboard');
    }


    public function RechazarTicket(Request $request){

        // return $request->all();
        $updateStatusRecipe  = Ticket::where('id',$request->id_consultorio)->limit(1)->update( [ 'status' => 2]);
        

        if($updateStatusRecipe){
            $userid = \DB::table('ticket')->select('ticket.userId')->where('ticket.id','=',(int)$request->id_consultorio)->get();
            $datosUser = \DB::table('users')->where('id','=',$userid[0]->userId)->get();
            $completo = $datosUser[0]->name;
            $email = $datosUser[0]->email;
            $data = array('mail_to'=>$email,
                          'completo'=>$completo
                      );
            Mail::send('site.mailings.08-ticket',['data'=>$data],function($message) use ($data){
                $message->to($data['mail_to'], $data['completo'])
                        ->subject('Ticket rechazado 😳');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Sabor que nos une');
            });
            return 1;
        }else{
            return 0;
        }

    }

    public function AceptarTicket(Request $request){


        $puntos_ticket = $request->puntos;
        $activeWeek = Week::where('status',1)->first();
        $updateStatusRecipe  = Ticket::where('id',$request->id_recipe)->limit(1)->update( [ 'status' => 1,'points'=>$puntos_ticket]);
        
        

        if($updateStatusRecipe){
            //$semanas = Week::select('*')->orderBy('id','desc')->first();

            $userid = \DB::table('ticket')->select('ticket.userId','ticket.created_at')->where('ticket.id','=',(int)$request->id_recipe)->get();
            $datosUser = \DB::table('users')->where('id','=',$userid[0]->userId)->get();
            $completo = $datosUser[0]->name;
            $email = $datosUser[0]->email;
            $data = array('mail_to'=>$email,
                          'completo'=>$completo
                      );

            Mail::send('site.mailings.01-confirmacion-ticket',['data'=>$data],function($message) use ($data){
                $message->to($data['mail_to'], $data['completo'])
                        ->subject('¡Ticket validado! 🙌');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Sabor que nos une');
            });
            return 1;
        }else{
            return 0;
        }
    }

    public function CreateWeekParticipation(){
        $semanas = Week::select('*')->orderBy('id','asc')->paginate(30);
        return view('site.admin.created_semanas',compact('semanas'));
    }

    public function CreateWeekByParticipation(){
        return view('site.admin.semanas_created');
    }

    public function SaveWeekByParticipation(Request $request){

        $newWeek = new Week();
        $newWeek->start = $request->fecha_inicio;
        $newWeek->end = $request->fecha_final;
        
        if($newWeek->save()){
            return 1;
        }else{
            return 0;
        }
        //return $request->all();
    }
    public function EditWeekByParticipation($id){
        $semana = Week::select('*')->where('id','=',(int)$id)->orderBy('id','asc')->first();
        return view('site.admin.edit_week',compact('semana'));
        //return $semana;
    }

    public function SaveWeekEditByParticipation(Request $request){

        $updateFecha  = Week::where('id',$request->id_fecha)->limit(1)->update( [ 'start' => $request->fecha_inicio,'end' => $request->fecha_final]);

        if($updateFecha){
            return 1;
        }else{
            return 0;
        }
        //return $request->all();
    }


    public function ActivateWeekCms(Request $request){
        $semana_activa = \DB::table('weeks')->select('*')->where('status',1)->first();
        if($semana_activa==null){
           $SeleccionadoUpdate= \DB::table('weeks')
                                ->where('id',(int)$request->id_week)
                                ->update(['status' => 1]);
            if($SeleccionadoUpdate==true){
                $jsonupdateTimeconcurso = json_encode(array('value'=>'success_active'));
                return $jsonupdateTimeconcurso;
            }
        }else{
            $SeleccionadoActualUpdate= \DB::table('weeks')
                                    ->where('id',(int)$semana_activa->id)
                                    ->update(['status' => 0]);
            if($SeleccionadoActualUpdate==true){

                $SeleccionadoUpdate= \DB::table('weeks')
                                    ->where('id',(int)$request->id_week)
                                    ->update(['status' => 1]);
                if($SeleccionadoUpdate==true){
                    $jsonupdateTimeconcurso = json_encode(array('value'=>'success_active'));
                    return $jsonupdateTimeconcurso;
                }
            }
        }
        
        //dd($semana_activa->id);
    }

    public function ReporteParticipaciones(){
      
        
        $recipes = Ticket::select(
                                  'ticket.id as ticket_id',
                                  'ticket.ticketImage',
                                  'ticket.status',
                                  'ticket.points',
                                  'ticket.created_at as fecha_alta_ticket',
                                  'users.name',
                                  'users.phone',
                                  'users.email')->join('users','ticket.userId','=','users.id')->get();
        // foreach($recipes as $recipe){
        //         $recipe->url = url('/').'/ver-receta/'.$recipe->id_receta.'/'.$recipe->slug_recipe;
        //     }
        $data = json_decode(json_encode($recipes), True);
        //dd($data);
        function cleanData(&$str)
        {
            // if ($str == 't') $str = 'TRUE';
            // if ($str == 'f') $str = 'FALSE';
            // if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str) || preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str)) {
            //     $str = " $str";
            // }
            // if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // filename for download
        $filename = "Participaciones" . date('Ymd') . ".csv";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/xlsx");
        header("Pragma: no-cache");
        header("Expires: 0");

        $out = fopen("php://output", 'w');

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display field/column names as first row
                fputcsv($out, array_keys($row), ',', '"');
                $flag = true;
            }
            array_walk($row, __NAMESPACE__ . '\cleanData');
            fputcsv($out, array_values($row), ',', '"');
        }

        fclose($out);
    }


    public function ReporteParticipantes(){
      
        
        $users = User::all();
        
        $data = json_decode(json_encode($users), True);
        //dd($data);
        function cleanData(&$str)
        {
            // if ($str == 't') $str = 'TRUE';
            // if ($str == 'f') $str = 'FALSE';
            // if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str) || preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str)) {
            //     $str = " $str";
            // }
            // if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // filename for download
        $filename = "Participantes" . date('Ymd') . ".csv";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/xlsx");
        header("Pragma: no-cache");
        header("Expires: 0");

        $out = fopen("php://output", 'w');

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display field/column names as first row
                fputcsv($out, array_keys($row), ',', '"');
                $flag = true;
            }
            array_walk($row, __NAMESPACE__ . '\cleanData');
            fputcsv($out, array_values($row), ',', '"');
        }

        fclose($out);
    }

    public function ReporteParticipantesValidas(){
    // $recipes = Recipe::join('users','recipe.user_id','=','users.id')->where('recipe.is_confirm_user','=',1)->where('is_confirm_ticket','=',1)->get();
        // $recipes = Recipe::select('recipe.id as id_receta',
        //                           'recipe.id_ticket',
        //                           'recipe.title_recipe',
        //                           'recipe.slug_recipe',
        //                           'recipe.recipe_image',
        //                           'recipe.image_final',
        //                           'recipe.Is_valid_recipe',
        //                           'recipe.created_at as fecha_alta_receta',
        //                           'tickets.id as ticket_id',
        //                           'tickets.user_id',
        //                           'tickets.semana_id',
        //                           'tickets.ticket_image',
        //                           'tickets.ticket_number',
        //                           'tickets.is_online',
        //                           'tickets.Is_valid',
        //                           'tickets.created_at as fecha_alta_ticket',
        //                           'users.name',
        //                           'users.last_name',
        //                           'users.phone',
        //                           'users.email')->join('tickets','recipe.id_ticket','=','tickets.id')
        //                     ->join('users','tickets.user_id','=','users.id')->where('tickets.Is_valid','=',1)->get();

         $recipes = Ticket::join('users','tickets.user_id','=','users.id')->where('tickets.Is_valid','=',1)->get();

        foreach($recipes as $recipe){
                $recipe->url = url('/').'/ver-receta/'.$recipe->id_receta.'/'.$recipe->slug_recipe;
            }
        $data = json_decode(json_encode($recipes), True);
        //dd($data);
        function cleanData(&$str)
        {
            // if ($str == 't') $str = 'TRUE';
            // if ($str == 'f') $str = 'FALSE';
            // if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str) || preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str)) {
            //     $str = " $str";
            // }
            // if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // filename for download
        $filename = "ParticipacionesValidas" . date('Ymd') . ".csv";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/xlsx");
        header("Pragma: no-cache");
        header("Expires: 0");

        $out = fopen("php://output", 'w');

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display field/column names as first row
                fputcsv($out, array_keys($row), ',', '"');
                $flag = true;
            }
            array_walk($row, __NAMESPACE__ . '\cleanData');
            fputcsv($out, array_values($row), ',', '"');
        }

        fclose($out);

    }

    public function ReporteParticipantesRechazadas(){
        $recipes = Ticket::join('users','tickets.user_id','=','users.id')->where('tickets.Is_valid','=',2)->get();
        // foreach($recipes as $recipe){
        //         $recipe->url = url('/').'/ver-receta/'.$recipe->id.'/'.$recipe->slug_recipe;
        //     }
        $data = json_decode(json_encode($recipes), True);
        //dd($data);
        function cleanData(&$str)
        {
            // if ($str == 't') $str = 'TRUE';
            // if ($str == 'f') $str = 'FALSE';
            // if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str) || preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str)) {
            //     $str = " $str";
            // }
            // if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // filename for download
        $filename = "ParticipacionesRechazadas" . date('Ymd') . ".csv";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/xlsx");
        header("Pragma: no-cache");
        header("Expires: 0");

        $out = fopen("php://output", 'w');

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display field/column names as first row
                fputcsv($out, array_keys($row), ',', '"');
                $flag = true;
            }
            array_walk($row, __NAMESPACE__ . '\cleanData');
            fputcsv($out, array_values($row), ',', '"');
        }

        fclose($out);
    }

    public function ReporteParticipacionesConfirm(){
        $recipes = User::select('users.name',
                                'users.last_name',
                                'users.phone',
                                'users.email',
                                'users.accpet_terms AS Acepto terminos',
                                'users.accpet_aviso AS Acepto aviso',
                                'users.accept_unilever AS Acepto terminos Unilever',
                                'users.accept_promos AS Acepto promos',
                                'recipe.id AS id_receta',
                                'recipe.ticket_image',
                                'recipe.ticket_number',
                                'recipe.title_recipe',
                                'recipe.slug_recipe',
                                'recipe.image_final',
                                'recipe.created_at AS creacion de la receta')->join('recipe','users.id','=','recipe.user_id')
                        ->where('recipe.is_confirm_user','=',0)->get();

        foreach($recipes as $recipe){
                $recipe->url = url('/').'/ver-receta/'.$recipe->id_receta.'/'.$recipe->slug_recipe;
            }
        $data = json_decode(json_encode($recipes), True);
        //dd($data);
        function cleanData(&$str)
        {
            // if ($str == 't') $str = 'TRUE';
            // if ($str == 'f') $str = 'FALSE';
            // if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str) || preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str)) {
            //     $str = " $str";
            // }
            // if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // filename for download
        $filename = "Participaciones_no_confirmadas" . date('Ymd') . ".csv";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/xlsx");
        header("Pragma: no-cache");
        header("Expires: 0");

        $out = fopen("php://output", 'w');

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display field/column names as first row
                fputcsv($out, array_keys($row), ',', '"');
                $flag = true;
            }
            array_walk($row, __NAMESPACE__ . '\cleanData');
            fputcsv($out, array_values($row), ',', '"');
        }

        fclose($out);

    }

    public function showsqlranking(){
        $ranking = \DB::table('redeemed_codes')
                            ->select('redeemed_codes.id_user','redeemed_codes.created_at','users.avatar','users.id','users.name','users.last_name','users.official_id_num','users.phone',DB::raw('SUM(point) AS score'))
                            ->join('users','redeemed_codes.id_user','=','users.id')
                            ->where('redeemed_codes.id_week','=',1)
                            ->where('users.status','=',1)
                            ->groupBy('redeemed_codes.id_user')
                            ->orderBy('score','DESC')->toSql();

        return $ranking;
    }

    public function ShowViewPosiblesGanadores(Request $request){
        $semana_activa = Week::where('status','=','1')->first();
        $ranking = \DB::table('redeemed_codes')
                            ->select('redeemed_codes.id_user','redeemed_codes.created_at','users.avatar','users.id','users.name','users.last_name','users.official_id_num','users.phone',DB::raw('SUM(point) AS score'))
                            ->join('users','redeemed_codes.id_user','=','users.id')
                            ->where('redeemed_codes.id_week','=',(int)$semana_activa->id)
                            ->where('users.status','=',1)
                            ->groupBy('redeemed_codes.id_user')
                            ->orderBy('score','DESC')->toSql();

        $data = json_decode(json_encode($ranking), True);
        //dd($data);
        function cleanData(&$str)
        {
            // if ($str == 't') $str = 'TRUE';
            // if ($str == 'f') $str = 'FALSE';
            // if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str) || preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str)) {
            //     $str = " $str";
            // }
            // if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // filename for download
        $filename = "ReportePosiblesGanadoresS".'HN'. date('Ymd') . ".csv";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/xlsx");
        header("Pragma: no-cache");
        header("Expires: 0");

        $out = fopen("php://output", 'w');

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display field/column names as first row
                fputcsv($out, array_keys($row), ',', '"');
                $flag = true;
            }
            array_walk($row, __NAMESPACE__ . '\cleanData');
            fputcsv($out, array_values($row), ',', '"');
        }

        fclose($out);
    }
    
}
