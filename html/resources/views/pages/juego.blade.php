@extends('layouts.master')
@section('title') Juego | La promo más furiosa @endsection

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
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
            <div class="h__sect h__01">
                <h3 id="game_title">
                    <i class="line l01"></i>
                    ¿Tienes lo que se necesita <br>
                    <span>para poder ganar?</span>
                    <i class="lna"></i>
                    <i class="line l02"></i>
                </h3>
            </div>
            <!-- // -->
            <!-- // Juego -->
            <div class="cont__juego">
                <!-- // -->
                <div class="marcador">
                    <div class="conta aciertos">
                        <span>Aciertos</span>
                        <div class="datos"><i id="contador">0</i>/10</div>
                    </div>
                    <div class="conta tiempo">
                        <span>Tiempo</span>
                        <div class="datos">
                            <div class="clock"><img src="{{ asset('img/icon-07.svg') }}" alt=""></div>
                            <div id="tiempo">00:00</div>
                        </div>
                    </div>
                </div>
                <!-- // -->
                <!-- // -->
                <div class="cont__tablero">
                    <div id="tablero"></div>
                    <!-- // Mensajes -->
                    <div class="cont__message">
                        <!-- // M:01 -->
                        <div class="mes__lb mes01">
                            <div class="lb__cen">
                                <div>
                                    <div class="listo">
                                        <span class="lins l01"></span>
                                        <span class="lins l02"></span>
                                        <div class="line__bg"></div>
                                        <div class="txt__lb txt__listo">
                                            ¿Estás <span>listo?</span>
                                        </div>
                                    </div>
                                    <div class="c__cta">
                                        <div class="cta cta01" id="iniciar_juego">Start</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // M:01 -->
                        <!-- // M:02 -->
                        <div class="mes__lb mes02" style="display: none;">
                            <div class="lb__cen">
                                <div>
                                    <div class="pop__name">
                                        <img src="{{ asset('img/logo_hot.webp') }}" alt="">
                                    </div>
                                    <div class="congrats">
                                        <span class="lins l01"></span>
                                        <span class="lins l02"></span>
                                        <div class="txt__lb txt__cong">
                                            <figure><img src="{{ asset('img/falmes.webp') }}" alt=""></figure>
                                            ¡Felicidades!
                                            <span>has acumulado</span>
                                        </div>
                                    </div>
                                    <div class="number__pun"><i id="loading" class="spinr"></i><span id="puntos__acu"></span> pts.</div>
                                    <p class="txt__ver">Verifica en tu perfil el total de puntos</p>
                                    <div class="c__cta">
                                        <a href="{{route('perfil')}}" class="cta cta02"><span>Ver Perfil</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // M:02 -->
                    </div>
                    <!-- // Mensajes -->
                </div>
                <!-- // -->
                <!-- // -->
                <div id="msn__alert">
                    <div class="msn__lb">
                        <span class="i__alert"><img src="{{ asset('img/icon-08.svg') }}" alt=""></span>
                        <p>“No cierres la ventana de juego o perderás tu oportunidad de ganar”</p>
                        <span class="i__alert"><img src="{{ asset('img/icon-08.svg') }}" alt=""></span>
                    </div>
                </div>
                <!-- // -->
                <div class="legals">
                    ©️ Universal City Studios LLC. All Rights Reserved. <br>
                    Dodge is a registered trademark of FCA US LLC. <br>
                    Jeep is a registered trademark of FCA US LLC.
                </div>
            </div>
            <!-- // Juego -->
        </div>
    </section>
</main>
<!-- // LB -->
<div class="cont__lb">
    <!-- lb01 -->
    <div class="lb__msn lb01">
        <div class="lb__center">
            <div class="cen__info">
                <div class="info__lb">
                    <div class="container">
                        <div class="icon">
                            <figure><img src="{{ asset('img/icon-04.svg') }}" alt=""></figure>
                        </div>
                        <div class="msn__lb">
                            <p>“No cierres la ventana mientras juegas o perderás tu oportunidad de ganar”</p>
                        </div>
                        <div class="c__cta">
                            <button class="cta cta01 clos__lb"><span>Aceptar</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- lb01 -->
    <!-- lb01 -->
    <div class="lb__msn lb02" style="display: none;">
        <div class="lb__center">
            <div class="cen__info">
                <div class="info__lb">
                    <div class="container-fluid">
                        <div class="icon">
                            <figure><img src="{{ asset('img/icon-04.svg') }}" alt=""></figure>
                        </div>
                        <div class="msn__lb">
                            <p>Notamos un comportamiento atípico que infringe los Términos y condiciones, tu participación será eliminada.</p>
                        </div>
                        <div class="c__cta">
                            <a href="{{route('home')}}" class="cta cta02 clos__lb"><span>Aceptar</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- lb01 -->
</div>
<!-- // LB -->

@section('page-script')
<!-- Aqui van los demás scripts -->
<script>
    const post_url      = '{{Route("fn.post_par")}}'
    const score_url     = '{{Route("fn.get_score")}}'
    const cheater_url   = '{{Route("fn.cheater")}}'
    const redirect_url  = '{{Route("ganadores")}}'
</script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/sec.js') }}"></script>
<script>
    window.onload = function() {
        var
        loader = $('.loader')

        tl = new TimelineLite();
        tl.to(loader,1,{autoAlpha:0, display: 'none',delay: 1})
    }
</script>
@stop
@endsection
