@extends('layouts.master')
@section('title') Registro | La promo más furiosa @endsection

@section('content')
<main>
    <!-- // -->
    <div class="bal">
        <span></span>
    </div>
    <!-- // -->
    @include('modules.mod-flamas')
    <section>
        <div class="container">
            <!-- // -->
            <div class="h__sect">
                <h3>Registro</h3>
            </div>
            <!-- // -->
            <!-- // -->
            <div class="cont__fomr f__large">
                <form action="#" id="registerForm" name="registerForm" method="post">
                    @csrf
                    <div class="cont__camp">
                        <div class="camp">
                            <label for="name">Nombre(s)</label>
                            <div class="c__imp">
                                <input type="text" id="name" name="name" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="last_name">Apellido(s)</label>
                            <div class="c__imp">
                                <input type="text" id="last_name" name="last_name" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="email">Correo electrónico</label>
                            <div class="c__imp">
                                <input type="email" id="email"  name="email" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="fecha_nacimiento">Fecha de nacimiento</label>
                            <div class="c__imp">
                                <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="phone">Teléfono</label>
                            <div class="c__imp">
                                <input type="tel" id="phone" name="phone" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="official_id_num">No. de documento</label>
                            <div class="c__imp">
                                <input type="text" id="official_id_num" name="official_id_num" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="city">Provincia</label>
                            <div class="c__imp">
                                <select name="city" id="city">
                                </select>
                                <i><img src="{{ asset('/img/a_down.svg') }}" alt=""></i>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="password">Contraseña</label>
                            <div class="contrasena">
                                <input type="password" id="password" name="password" autocomplete="off">
                            </div>
                        </div>
                        <div class="camp">
                            <label for="password_confirmation">Confirmar contraseña</label>
                            <div class="confirm_contrasena">
                                <input compare="password" type="password" name="password_confirmation" id="password_confirmation" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="cont__camp check__legal">
                        <div class="camp check">
                            <label for="privacy_terms">
                                <input type="checkbox" name="privacy_terms" id="privacy_terms" value="1">
                                <i></i>
                                <span>Acepto <a href="{{route('aviso')}}">Aviso de privacidad</a> y <a href="{{route('terminos')}}">Términos y condiciones</a></span>
                            </label>
                        </div>
                        <div class="camp check">
                            <label for="whatsapp_consent">
                                <input type="checkbox" name="whatsapp_consent" id="whatsapp_consent" value="1">
                                <i></i>
                                <span>Acepto recibir información por Whatsapp</span>
                            </label>
                        </div>
                    </div>
                    <div class="cont__camp">
                        <ul class="msn__erro">
                            <li style="display: none" id="show_name"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Ingresa tu nombre</li>
                            <li style="display: none" id="show_last_name"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Ingresa tu/s apellido/s</li>
                            <li style="display: none" id="show_email"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Ingresa un correo válido</li>
                            <li style="display: none" id="show_fecha_nacimiento"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Ingresa tu fecha de nacimiento</li>
                            <li style="display: none" id="show_phone"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Ingresa un número telefónico válido</li>
                            <li style="display: none" id="show_phone_oparator"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Selecciona un operador</li>
                            <li style="display: none" id="show_type_document"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Selecciona un tipo de documento</li>
                            <li style="display: none" id="show_official_id_num"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Ingresa el número de documento</li>
                            <li style="display: none" id="show_city"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Selecciona una Provincia</li>
                            <li style="display: none" id="show_password"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Ingresa tu contraseña</li>
                            <li style="display: none" id="show_password_confirm"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Confirma tu contraseña</li>
                            <li style="display: none" id="show_password_same"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Las contraseñas no coinciden</li>
                            <li style="display: none" id="show_politicas"><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Debes aceptar el Aviso de Privacidad y Terminos y Condiciones</li>
                        </ul>
                    </div>
                    <div class="c__cta">
                        <button class="cta cta01" id="sendBtn"><span>Regístrarme</span></button>
                    </div>
                </form>
            </div>
            <!-- // -->
        </div>
    </section>
</main>

@section('page-script')
<script src="{{ asset('js/formulariojs.js') }}"></script>
<!-- Aqui van los demás scripts -->
<script>
    window.onload = function() {
        var
        bars = $('.loader div div')
        prom = $('.prom figure')
        loader = $('.loader')

        tl = new TimelineLite();
        tl
        .to(prom, .8,{y: '100%', delay: 1})
        .staggerFromTo(bars,3,{scaleY:1,},{scaleX:0, ease: Elastic.easeOut.config(1, 0.7)},0.15, '-=.7')
        .to(loader,.1,{autoAlpha: 0, display: 'none'}, '-=1')
    }

    $( function() {
        $( "#fecha_nacimiento" ).datepicker({
            changeMonth: true,
            changeYear: true,
            language: 'es',
            closeText: 'Cerrar',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
             yearRange: '1920 : 2005',
        });
      } );
</script>
@stop
@endsection
