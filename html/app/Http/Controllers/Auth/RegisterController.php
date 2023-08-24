<?php

namespace App\Http\Controllers\Auth;

use App\City;
use App\User;
use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function showRegistrationForm()
    {
        $cities = City::get();
        return view('auth.register', compact('cities'));
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'               => 'required',
            'last_name'          => 'required',
            'email'              => 'required|email|unique:users,email',
            'birthday'           => 'required|date_format:d/m/Y',
            'phone'              => 'required|numeric|unique:users,phone',
            'identity_card'      => 'required|string|size:'.Helper::getIdentityCardType()['lenght'],
            'city'               => 'required|exists:cities,id',
            'password'           => 'required|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'privacy_terms'      => 'required|accepted',
            // 'whatsapp_consent'   => 'nullable|accepted',
        ], [
            'name.required' => 'Ingresa tu nombre(s).',
            'last_name.required' => 'Ingresa tu apellido(s).',
            'email.required' => 'Ingresa un correo válido.',
            'email.email' => 'Ingresa un correo válido.',
            'email.unique' => 'Ya existe una cuenta con este correo.',
            'birthday.required' => 'Ingresa tu fecha de nacimiento.',
            'birthday.date_format' => 'Ingresa una fecha de nacimiento válida.',
            'phone.required' => 'Ingresa tu télefono.',
            'phone.numeric' => 'Ingresa tu télefono.',
            'phone.unique' => 'Ya existe una cuenta con este número de télefono.',
            'identity_card.required' => 'Ingresa tu número de documento de identidad.',
            'identity_card.size' => 'El número de documento de identidad debe ser de '.Helper::getIdentityCardType()['lenght'].' caracteres.',
            'city.required' => 'Selecciona tu Provincia.',
            'city.exists' => 'La Provincia seleccionada no existe.',
            'password.required' => 'Ingresa una contraseña.',
            'password.confirmed' => 'Las contraseñas deben de coincidir.',
            'password.regex' => 'Tu contraseña debe tener al menos una letra mayúscula, una letra minúscula, un número, un caracter especial(#$) y debe tener almenos 8 catacteres de largo',
            'privacy_terms.required' => 'Es necesario aceptar los Aviso de privacidad y Términos y condiciones.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create($data)
    {
        return User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'birthday' => $data['birthday'],
            'phone' => $data['phone'],
            'identity_card' => $data['identity_card'],
            'city' => $data['city'],
            'password' => $data['password'],
            'privacy_terms' => $data['privacy_terms'],
            'whatsapp_consent' => $data['whatsapp_consent'] ?? null,
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return redirect()->route('valida-tu-correo');
    }
}
