<?php

namespace App\Http\Controllers;
use App\Providers\StorageProvider;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//use Yajra\Datatables\Facades\Datatables;
use App\User;
use DB;
use Auth;
use App\Ticket;
use Hash;

class TicketsController extends Controller
{
    //
    public function index( Request $request )
    {
        if ($request->ajax()) {
            $data = Ticket::select('ticket.id as id_ticket',
                                    'ticket.created_at as fecha_alta_ticket',
                                    'users.name',
                                    'users.email',
                                    'users.phone')->join('users','ticket.userId','users.id')
                                                  ->where('ticket.status',0)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="'.route('participantes.showdetallereceta', $row->id_ticket).'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="btn btn-primary">Ver Tickets</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('site.admin.tickets.index');
        //return '1234';
    }


    public function TicketsValidados( Request $request )
    {
        //dd('jjhjhdjhdj');
        if ($request->ajax()) {
            $data = Ticket::select('ticket.id as id_ticket',
                                    'ticket.created_at as fecha_alta_ticket',
                                    'users.name',
                                    'users.email',
                                    'users.phone')->join('users','ticket.userId','users.id')
                                                  ->where('ticket.status',1)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="'.route('participantes.showdetallereceta', $row->id_ticket).'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="btn btn-primary">Ver Tickets</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('site.admin.tickets.validada');
        //return '1234';
    }

    public function TicketsRechazados( Request $request )
    {
        if ($request->ajax()) {
            $data = Ticket::select('ticket.id as id_ticket',
                                    'ticket.created_at as fecha_alta_ticket',
                                    'users.name',
                                    'users.email',
                                    'users.phone')->join('users','ticket.userId','users.id')
                                                  ->where('ticket.status',2)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="'.route('participantes.showdetallereceta', $row->id_ticket).'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="btn btn-primary">Ver Tickets</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('site.admin.tickets.rechazada');
        //return '1234';
    }


    public function show(Request $request,$id)
    {   
        $id_user = (int)$id;
         if ($request->ajax()) {
            $data = Ticket::select('ticket.id as id_ticket','ticket.userId','ticket.status','ticket.created_at as fecha_alta_ticket','users.id','users.id','users.name')->join('users','ticket.userId','=','users.id')->where('ticket.userId',(int)$id)->where('ticket.status','=',1)->get();
            // foreach($data as $recipe){
            //     $recipe->url = url('/').'/ver-receta/'.$recipe->id.'/'.$recipe->slug_recipe;
            // }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="'.route('participantes.showdetallereceta', $row->id_ticket).'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="btn btn-primary">Ver detalle ticket</a>';
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

}
