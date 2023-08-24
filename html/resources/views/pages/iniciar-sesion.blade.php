@extends('layouts.master')
@section('title') Iniciar sesión | La promo más furiosa @endsection

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
                <h3>Iniciar sesión</h3>
            </div>
            <!-- // -->
            <!-- // -->
            <div class="cont__fomr f__min">
                <form method="POST" action="{{route('iniciar-sesion')}}">
                    @csrf
                    <div class="cont__camp">
                        <div class="camp">
                            <label for="correo">Correo electrónico*</label>
                            <div class="c__imp">
                                <input type="text"  name="email" id="email"  placeholder="Correo electrónico" >
                            </div>
                        </div>
                        <div class="camp">
                            <label for="contrasena">Contraseña*</label>
                            <div class="c__imp">
                                <input id="password" type="password"  name="password" autocomplete="off">
                                <!-- // -->
                                <div class="cont__i">
                                    <div class="icon__i">
                                        <span>i</span>
                                    </div>
                                    <div class="txt__i">
                                        Recuerda que si te registraste vía Chatbot (WhatsApp), deberás usar la contraseña recibida por mail.
                                    </div>
                                </div>
                                <!-- // -->
                            </div>
                            <div class="forget">
                                <a href="{{route('recuperar-contrasena')}}"><u>Olvide mi contraseña</u></a>
                            </div>
                        </div>
                    </div>
                    <div class="cont__camp">
                        <ul class="msn__erro" id="error_fields">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <li><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>{{ $error }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="c__cta">
                        <button class="cta cta01" id="sendBtn"><span>Entrar</span></button>
                    </div>
                </form>
                <div class="c__cta">
                    <p>Si no tienes una cuenta</p>
                    <a href="{{route('registro')}}" class="cta cta02"><span>Regístate aquí</span></a>
                </div>
            </div>
            <!-- // -->
        </div>
    </section>
</main>

@section('page-script')
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

    $(".icon__i").on("click",function(){
        $('.txt__i').toggleClass('active');
    });
    $(".txt__i").on("click",function(){
        $(this).removeClass('active');
    });
</script>
@stop
@endsection
