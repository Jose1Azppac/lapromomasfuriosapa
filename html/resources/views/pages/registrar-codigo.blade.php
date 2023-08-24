@extends('layouts.master')
@section('title') Registrar código | La promo más furiosa @endsection

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
                <h3>¡Participa!</h3>
                <p>Recuerda que entre más códigos registres, más oportunidades tienes de ganar.</p>
            </div>
            <!-- // -->
            <div class="re__cod">
                <form id="form-code" autocomplete="off" method="POST" class="col-3 d-flex flex-column justify-content-center align-items-center">
                    @csrf
                    <h3>1. Selecciona tu producto</h3>
                    <div class="s__opt">
                        <div>
                            <label for="snacks_salados">
                                <input type="radio" id="snacks_salados" name="producto" value="snacks_salados">
                                <figure>
                                    <img src="{{ asset('img/logo01.svg') }}" alt="">
                                </figure>
                                <span>Salados</span>
                            </label>
                        </div>
                        <div>
                            <label for="galletas">
                                <input type="radio" id="galletas" name="producto" value="galletas">
                                <figure>
                                    <img src="{{ asset('img/logo02.svg') }}" alt="">
                                </figure>
                                <span>Galletas</span>
                            </label>
                        </div>
                    </div>
                    <!-- // Registro de codigo-->
                    <div id="CampoCodigo" style="display: none;">
                        <!-- // -->
                        <div class="info__regis">
                            <h4>Código único</h4>
                            <p>El Código único lo encontrarás en el empaque como lo muestra la imágen.</p>
                            <figure>
                                <img src="{{ asset('img/img-codigo.webp') }}" alt="">
                                <figcaption><strong>Ingrésalo así:</strong> DO6182741125</figcaption>
                            </figure>
                            <p>Toma en cuenta mayúsculas y minúsculas, no se deben tomar en cuenta espacios y signos.</p>
                            <p><strong>Recuerda:</strong> <br>Guardar tus empaques para poder reclamar tu premio si resultas ganador.</p>
                            <p>Más información en <a href="{{route('terminos')}}" target="_blank"><span>Términos y condiciones</span></a></p>
                        </div>
                        <!-- // -->
                        <h3>2. Registra tu código</h3>
                        <div class="fil__res" >
                            <div class="compo__res">
                                 <input type="text" name="codigo" id="codigo"  placeholder="0000000000">
                            </div>
                            <div class="btn__res">
                                <button class="cta cta01 sendBtnMemorama" id="sendBtn"><span>Enviar código</span></button>
                            </div>
                        </div>
                    </div>
                    <!-- // Registro de codigo-->
                    <!-- // Registro de lote -->
                    <div id="CampoLote" style="display: none;">
                        <!-- // -->
                        <div class="info__regis">
                            <h4>Número de lote</h4>
                            <p>El número de lote lo encontrarás en el empaque como lo muestra la imágen.</p>
                            <figure>
                                <img src="{{ asset('img/img-lote.webp') }}" alt="">
                                <figcaption><strong>Ingrésalo así:</strong> 02OCT2224VA125110844AM</figcaption>
                            </figure>
                            <p>Toma en cuenta mayúsculas y minúsculas, no se deben tomar en cuenta espacios y signos.</p>
                            <p><strong>Recuerda:</strong> <br>Guardar tus empaques para poder reclamar tu premio si resultas ganador.</p>
                            <p>Más información en <a href="{{route('terminos')}}" target="_blank"><span>Términos y condiciones</span></a></p>
                        </div>
                        <!-- // -->
                        <h3>2. Registra tu lote</h3>
                        <div class="fil__res" >
                            <div class="compo__res">
                                 <input type="text" name="lote" id="lote"  placeholder="02OCT2324VA1251107:44AM">
                            </div>
                            <div class="btn__res">
                                <button class="cta cta01 sendBtnMemorama" id="sendBtn"><span>Enviar lote</span></button>
                            </div>
                        </div>
                    </div>
                    <!-- // Registro de lote -->
                </form>
            </div>
        </div>
    </section>
</main>
<!-- // LB -->
<div class="cont__lb">
    <div class="lb__msn lb01" id='err_lb' style="display: none;">
        <div class="lb__center">
            <div class="cen__info">
                <div class="info__lb">
                    <div class="container">
                        <div class="icon">
                            <figure><img src="{{ asset('img/icon-04.svg') }}" alt=""></figure>
                        </div>
                        <div class="msn__lb">
                            <p id="err_msg"> Esté código ya ha sido registrado, intenta con otro</p>
                        </div>
                        <div class="c__cta">
                            <button class="cta cta01 clos__lb"><span>Aceptar</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // LB -->


@section('page-script')
<!-- Aqui van los demás scripts -->
<script>
    $('input[type=radio][name=producto]').change(function() {
        if (this.value == 'snacks_salados' || this.value == 'Tortix') {
            $('#CampoCodigo').fadeIn();
            $('#CampoLote').hide();
        }
        else if (this.value == 'galletas') {
            $('#CampoLote').fadeIn();
            $('#CampoCodigo').hide();
        }
    });
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
    const ajaxurl = "{{ route('fn.validar') }}"
    const gameurl = "{{ route('juego') }}"
</script>
<script src="{{ asset('assets/js/form.js') }}"></script>
@stop
@endsection
