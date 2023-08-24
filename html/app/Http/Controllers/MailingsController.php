<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailingsController extends Controller
{
    public function registro() {
        return view('mailings.01-registro');
    }
    public function recuperar_contrasena() {
        return view('mailings.02-recuperar-contrasena');
    }
    public function envio_info() {
        return view('mailings.03-envio-info');
    }
    public function info_aceptada() {
        return view('mailings.04-info-aceptada');
    }
    public function info_rechazada() {
        return view('mailings.05-info-rechazada');
    }
    public function gandor() {
        return view('mailings.06-ganador');
    }
    public function contacto() {
        return view('mailings.07-contacto');
    }
}
