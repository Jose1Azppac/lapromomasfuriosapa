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
                <form action="{{route('registro')}}" method="post">
                    @csrf
                    <div class="cont__camp">
                        <div class="camp">
                            <label for="name">Nombre(s)</label>
                            <div class="c__imp">
                                <input type="text" id="name" name="name" autocomplete="off" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="last_name">Apellido(s)</label>
                            <div class="c__imp">
                                <input type="text" id="last_name" name="last_name" autocomplete="off" value="{{old('last_name')}}" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="email">Correo electrónico</label>
                            <div class="c__imp">
                                <input type="email" id="email"  name="email" autocomplete="off" value="{{old('email')}}" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="birthday">Fecha de nacimiento</label>
                            <div class="c__imp">
                                <input type="text" id="birthday" name="birthday" autocomplete="off" value="{{old('birthday')}}" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="phone">Teléfono</label>
                            <div class="c__imp">
                                <input type="tel" id="phone" name="phone" autocomplete="off" value="{{old('phone')}}" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="identity_card">No. de {{$identity_card_type['title']}}</label>
                            <div class="c__imp">
                                <input type="text" id="identity_card" name="identity_card" autocomplete="off" value="{{old('identity_card')}}" required>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="city">Provincia</label>
                            <div class="c__imp">
                                <select name="city" id="city">
                                        <option value="">Selecciona una opción</option>
                                    @foreach ($cities as $c)
                                        <option value="{{$c->id}}" {{old('city') == $c->id ? 'selected' : null}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                                <i><img src="{{ asset('/img/a_down.svg') }}" alt=""></i>
                            </div>
                        </div>
                        <div class="camp">
                            <label for="password">Contraseña</label>
                            <div class="contrasena">
                                <input type="password" id="password" name="password" autocomplete="off" value="{{old('password')}}">
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
                                <input type="checkbox" name="privacy_terms" id="privacy_terms" value="on" required>
                                <i></i>
                                <span>Acepto <a href="{{route('aviso')}}">Aviso de privacidad</a> y <a href="{{route('terminos')}}">Términos y condiciones</a></span>
                            </label>
                        </div>
                        <div class="camp check">
                            <label for="whatsapp_consent">
                                <input type="checkbox" name="whatsapp_consent" id="whatsapp_consent" value="on">
                                <i></i>
                                <span>Acepto recibir información por Whatsapp</span>
                            </label>
                        </div>
                    </div>
                    <div class="cont__camp">
                        <ul class="msn__erro">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <li><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>{{ $error }}</li>
                                @endforeach
                            @endif
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
        $( "#birthday" ).datepicker({
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
