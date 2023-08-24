<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Code;
use App\User;
use App\Week;
use Exception;
use Carbon\Carbon;
use App\Helper\Mongo;
use App\Helper\Helper;
use App\Models\UserCode;
use Illuminate\Support\Str;
use App\Mail\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Repositories\GameLogRepository;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function useCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'              => 'required',
            'phone'             => 'required',
            'product'           => ['required', Rule::in(['snacks_salados', 'tortix', 'galletas']) ],
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'message' => 'error', 'data' => [
                'validations' => $validator->errors()
            ]  ], 422);
        }

        try{
            $user = User::where('phone', $request->phone)->first();
            if(!$user){
                return response()->json([ 'code' => 0, 'message' => 'Incorrect username', 'data' => [] ], 200);
            }

            $CodebyInDay = UserCode::where('user_id', $user->id)->whereDate('created_at', '=', Carbon::today()->toDateString())
                            ->get()->count();
            if($CodebyInDay >= 15){
                return response()->json([ 'code' => 0, 'message' => 'you have exceeded the limit of participations per day.', 'data' => [] ], 200);
            }

            if (!Helper::validateParticipationUser($user->id, $request->product)) {
                return response()->json([
                    'code' => 0,
                    'message' => "you have exceeded today's limit for this product.",
                    'data' => []
                ]);
            }

            if( !($request->product == 'galletas') ) {
                $mongo = Mongo::redeemCode($user->id, $request->code);
                if($mongo->status_redimed != 1){
                    return response()->json([ 'code' => 0, 'message' => 'The code is invalid or has already been used.', 'data' => [] ], 200);
                }
            }

            $hash = self::hash();

            $code = $user->codes()->create([
                'code' => $request->code,
                'hash' => $hash,
                'status' => 0
            ]);

            $user_code = new UserCode;
            $user_code->user_id  = $user->id;
            $user_code->week_id  = Week::active()->first()->id;
            $user_code->code     = $request->code;
            $user_code->producto = $request->product;
            $user_code->save();

            $url = route('whatsapp.game', ['hash' => $code->hash]);

            return response()->json([ 'code' => 1,
                'message' => 'success.',
                'data' => [ 'link' => $url ]
            ], 200);

        }catch(Exception $e){
            return response()->json([ 'code' => 0,
            'message' => 'error'.$e->getMessage(),
            'data' => [] ], 500);
        }
    }
    public static function hash(){
        $hash = sha1( Str::random(5) );
        if( Code::where('hash',$hash)->first() ) return self::hash();
        return $hash;
    }

    public function userPointsCurrent(Request $request)
    {
        $user = User::where('phone', $request->user)->first();
        if(!$user){
            return response()->json([ 'code' => 0, 'message' => 'Incorrect username', 'data' => [] ], 200);
        }

        $week = Week::active()->first();

        $game = new GameLogRepository();
        $weekActivePoints = $game->get_user_codes_by_week_id_with_points($user->id, $week->id);

        return response()->json(['code' => 1, 'message' => 'success',
        'data' => [ 'points' => $weekActivePoints ,'week' => $week  ,'user' => $user ]
        ]);
    }
    public function userPointsGlobal(Request $request)
    {
        $user = User::where('phone', $request->user)->first();
        if(!$user){
            return response()->json([ 'code' => 0, 'message' => 'Incorrect username', 'data' => [] ], 200);
        }

        $game = new GameLogRepository();
        $globalPoints = $game->get_points_global_by_user($user->id);

        return response()->json(['code' => 1, 'message' => 'success',
        'data' => [ 'points' => $globalPoints ,'user' => $user ]
        ]);
    }
}
