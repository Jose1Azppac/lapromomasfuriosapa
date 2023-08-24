<?php

namespace App\Http\Controllers;
use App\Providers\StorageProvider;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//use Yajra\Datatables\Facades\Datatables;
use App\User;
use DB;
use Auth;
use App\RedeemedCode;
use App\Semana;
use Hash;

class ParticipantesController extends Controller
{
    //
    public function index( Request $request )
    {
        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="'.route('participantes.show', $row->id).'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="btn btn-primary">Ver codigos</a>';

                           $btn .= '<a href="'.route('participantes.showdetalle',$row->id).'" data-toggle="tooltip"  data-id="'.$row->id_user.'" data-original-title="Editar" class="btn btn-success">Declarar ganador</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('site.admin.user.index');
        //return '1234';
    }


    public function show(Request $request,$id)
    {   

        $id_user = (int)$id;
        
         if ($request->ajax()) {
            $data = RedeemedCode::select('redeemed_codes.id as id_lote','redeemed_codes.id_user','redeemed_codes.created_at as fecha_alta_lote','users.id','users.name')->join('users','redeemed_codes.id_user','=','users.id')->where('redeemed_codes.id_user',(int)$id)->get();
            // foreach($data as $recipe){
            //     $recipe->url = url('/').'/ver-receta/'.$recipe->id.'/'.$recipe->slug_recipe;
            // }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="'.route('participantes.showdetallereceta', $row->id_lote).'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="btn btn-primary">Ver detalle ticket</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
         }
        // //dd($data);
        return view('site.admin.recipe.index',compact('id_user'));
        //return $id;
         // $data = Ticket::select('tickets.id as id_ticket','tickets.user_id','tickets.ticket_number','tickets.is_online','tickets.Is_valid','tickets.created_at as fecha_alta_ticket','users.id','users.id','users.name')->join('users','tickets.user_id','=','users.id')->where('tickets.user_id',(int)$id)->where('tickets.Is_valid','=',1)->toSql();
         // return $data;
    }


    public function ShowInfoParticipacion($id){
        $detalleParticipacion = \DB::table('redeemed_codes')
                                ->select('redeemed_codes.id',
                                         'redeemed_codes.id_user',
                                         'redeemed_codes.imagen_lote',
                                         'redeemed_codes.created_at',
                                         'users.name',
                                         'users.email',
                                         'users.phone')
                                ->join('users','redeemed_codes.id_user','=','users.id')
                                ->where('redeemed_codes.id','=',(int)$id)
                                ->orderBy('redeemed_codes.created_at','desc')->first();

        //dd($detalleParticipacion);
        //$semanas = Semana::select()->orderBy('id','asc')->get();
        //dd($semanas);
        return view('site.admin.detalle_receta',compact('detalleParticipacion'));
    }


    public function ShowInfoUser($id){
        //dd($id);
        $semanas = Semana::all();
        $detalle_users = User::where('id',(int)$id)->first();
        // $detalleParticipacion = \DB::table('ticket')
        //                         ->select('ticket.id',
        //                                  'ticket.userId',
        //                                  'ticket.ticketImage',
        //                                  'ticket.created_at',
        //                                  'users.name',
        //                                  'users.email',
        //                                  'users.phone')
        //                         ->join('users','ticket.userId','=','users.id')
        //                         ->where('ticket.id','=',(int)$id)
        //                         ->orderBy('ticket.created_at','desc')->first();

        //dd($detalleParticipacion);
        //$semanas = Semana::select()->orderBy('id','asc')->get();
        //dd($semanas);
        return view('site.admin.ganadores.detalle-participante',compact('detalle_users','semanas'));
    }


    
}
