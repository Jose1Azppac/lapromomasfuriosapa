<?php

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use Mail;
use App\User;
use Exception;
use Illuminate\Support\Str;
use App\Mail\UserRegistered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'               => 'required',
            'last_name'          => 'required',
            'email'              => 'required|email|unique:users,email',
            'birthday'           => 'required|date_format:Y-m-d',
            'phone'              => 'required|numeric|unique:users,phone',
            'identity_card'      => 'required|string|size:'.Helper::getIdentityCardType()['lenght'],
            'city'               => 'required',
            'privacy_terms'      => 'required|accepted',
            // 'whatsapp_consent'   => 'nullable|accepted',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'message' => 'validation failure', 'data' => [
                'validations' => $validator->errors()
            ]  ], 422);
        }
        try{
            $password = Str::random(10);
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'birthday' => $request->birthday,
                'phone' => $request->phone,
                'identity_card' => $request->identity_card,
                // 'identity_card_type' => $request->identity_card_type,
                'city' => $request->city,
                'password' => $password,
                'privacy_terms' => $request->privacy_terms,
                'whatsapp_consent' => $request->whatsapp_consent,
            ]);
            $user->password_temp = $password;

            event(new Registered($user));

        }catch(Exception $e){
            return response()->json([
                'code' => 1,
                'message' => 'error:'.$e->getMessage(),
                'line' => 'line:'.$e->getLine(),
                'data' => []
            ], 500);
        }

        return response()->json([
            'code' => 1,
            'message' => 'success',
            'data' => ['user' => $user]
        ], 200);
    }

    public function getUser(Request $request)
    {
        try{
            $user = User::where('phone', $request->user)->first();
        }catch(Exception $e){
            return response()->json([ 'code' => 0, 'message' => 'error', 'data' => [] ], 500);
        }

        return response()->json([ 'code' => 1, 'message' => 'success', 'data' => ['user' => $user], ], 200);
    }
}
