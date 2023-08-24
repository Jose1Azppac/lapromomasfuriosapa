<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MailingsController;
use App\Http\Controllers\FunctionsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes([ 'register' => false, 'verify' => true ]);

Route::get('teaser', [PageController::class,'teaser'])->name('teaser');
Route::get('fin-promo', [PageController::class,'fin_promo'])->name('fin-promo');

Route::get('/', [PageController::class,'home'])->name('home');
Route::get('iniciar-sesion', [PageController::class,'iniciar'])->name('iniciar-sesion');
Route::post('iniciar-sesion', [LoginController::class,'login']);
Route::get('logout', [LoginController::class,'logout']);

Route::get('recuperar-contrasena', [PageController::class,'recuperar'])->name('recuperar-contrasena');
Route::get('cambiar-contrasena/{token}/{email}', [PageController::class,'cambiar'])->name('cambiar-contrasena');
Route::get('contrasena-actualizada', [PageController::class,'actualizada'])->name('contrasena-actualizada');

Route::get('registro', [RegisterController::class,'showRegistrationForm'])->name('registro');
Route::post('registro', [RegisterController::class,'register']);

Route::get('registro-exitoso', [PageController::class,'registro_exitoso'])->name('registro-exitoso');

/*Route::get('ranking-diario', [PageController::class,'ranking_diario'])->name('ranking-diario');*/
Route::get('ranking-semanal', [PageController::class,'ranking_Weekl'])->name('ranking-semanal');
Route::get('ranking-quincenal', [PageController::class,'ranking_quincenal'])->name('ranking-quincenal');

Route::get('ganadores', [PageController::class,'ganadores'])->name('ganadores');

Route::get('contacto', [PageController::class,'contacto'])->name('contacto');
Route::get('gracias', [PageController::class,'gracias'])->name('gracias');

Route::get('aviso-de-privacidad', [PageController::class,'aviso'])->name('aviso');
Route::get('terminos-y-condiciones', [PageController::class,'terminos'])->name('terminos');
Route::get('faqs', [PageController::class,'faqs'])->name('faqs');

Route::get('whatsapp/juego/{hash}',[PageController::class, 'whatsappGame'])->name('whatsapp.game');
Route::middleware(['auth'])->group(function(){
    Route::get('perfil', [PageController::class,'profile'])->name('perfil');
    Route::get('valida-tu-correo', [PageController::class,'valida'])->name('valida-tu-correo');
    Route::get('reenviar-validacion-correo', [VerificationController::class,'resend'])->name('reenviar-validacion-correo');

	Route::get('registrar-codigo',[PageController::class, 'registrar_codigo'])->middleware('verified')->name('registrar-codigo');
	Route::get('juego',             [PageController::class, 'juego'])->middleware('verified')->name('juego');

    Route::post('validar',          [FunctionsController::class, 'validar_codigo'                ])->middleware('verified')->name('fn.validar');
    Route::post('memorama_post',    [FunctionsController::class, 'memorama_post'                 ])->middleware('verified')->name('fn.post');
    Route::post('cheater',          [FunctionsController::class, 'cheater_post'                  ])->middleware('verified')->name('fn.cheater');
    Route::post('memorama_post_par', [FunctionsController::class, 'memorama_post_nuevo_par'      ])->middleware('verified')->name('fn.post_par');
    Route::post('memorama_get_score',[FunctionsController::class, 'memorama_get_total_score'     ])->middleware('verified')->name('fn.get_score');
});

Route::get('informacion-registrada', [PageController::class,'info_registrada'])->name('informacion-registrada');
// Mailings
Route::get('01-registro', [MailingsController::class,'registro'])->name('01-registro');
Route::get('02-recuperar-contrasena', [MailingsController::class,'recuperar_contrasena'])->name('02-recuperar-contrasena');
Route::get('03-envio-info', [MailingsController::class,'envio_info'])->name('03-envio-info');
Route::get('04-info-aceptada', [MailingsController::class,'info_aceptada'])->name('04-info-aceptada');
Route::get('05-info-rechazada', [MailingsController::class,'info_rechazada'])->name('05-info-rechazada');
Route::get('06-ganador', [MailingsController::class,'gandor'])->name('06-ganador');
Route::get('07-contacto', [MailingsController::class,'contacto'])->name('07-contacto');
/**Ruta para enviar mail de contacto */
Route::post('/contacto/enviar', 'ContactoSender@SendEmailContact')->name("sendContact");
/**
 * routes for cms
 */
Route::group(['prefix'=>'cms'], function(){
    Route::post('/verificar','AdminCmsController@VerifyLoginAdmin')->name('cms.verificar');
    Route::get('/login','AdminCmsController@LoginPage')->name('cms.login');
    Route::get('/dashboard','AdminCmsController@dashboard')->name('cms.dashboard');
    Route::get('/participaciones','AdminCmsController@Participaciones')->name('cms.participaciones');
    /*Participantes*/
    Route::get('participantes', function ()       { return redirect('participantes/index'); });
    Route::resource('participantes','ParticipantesController');
    Route::get('/participantes/receta/detalle/{id}','ParticipantesController@ShowInfoParticipacion')->name('participantes.showdetallereceta');


    Route::get('/participante/detalle/{id}','ParticipantesController@ShowInfoUser')->name('participantes.showdetalle');

    /*Tickets*/
    Route::get('tickets', function ()       { return redirect('tickets/index'); });
    Route::resource('tickets','TicketsController');

    Route::get('/participaciones/validos','TicketsController@TicketsValidados')->name('tickets.validos');
    Route::get('/participaciones/rechazados','TicketsController@TicketsRechazados')->name('tickets.novalidos');

    /*Semanas del concurso*/
    Route::get('/semanas','AdminCmsController@CreateWeekParticipation')->name('cms.semanas');
    Route::get('/semanas/creacion','AdminCmsController@CreateWeekByParticipation')->name('cms.crear_concurso');
    Route::post('/saveweek','AdminCmsController@SaveWeekByParticipation')->name('cms.saveweek');
    Route::get('/semanas/editar/{id}','AdminCmsController@EditWeekByParticipation')->name('cms.editsemana.id');
    Route::post('/saveweekedit','AdminCmsController@SaveWeekEditByParticipation')->name('cms.SaveWeekEditByParticipation');


    Route::post('activate_week','AdminCmsController@ActivateWeekCms')->name('cms.activate_week');

    Route::post('/rechazarticket','AdminCmsController@RechazarTicket')->name('cms.rechazarticket');
    Route::post('/aceptarticket','AdminCmsController@AceptarTicket')->name('cms.aceptarticket');

});
