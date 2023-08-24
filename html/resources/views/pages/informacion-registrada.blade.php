@extends('layouts.master')
@section('title') Empaque registrado | La promo más furiosa @endsection

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
            <div class="cont__msn">
                <!-- // -->
                <div class="icon i__02">
                    <figure><img src="{{ asset('img/icon-09.svg') }}" alt=""></figure>
                </div>
                <!-- // -->
                <div class="h__sect">
                    <h3>¡Registro de empaque exitoso!</h3>
                </div>
                <!-- // -->
                <p class="txt__msn">Entre más empaques registres, más oportunidades tendrás de ganar.</p>
                <!-- // -->
                <div class="c__cta">
                    <a href="{{route('registrar-codigo')}}" class="cta cta01"><span>Enviar otro código</span></a>
                </div>
            </div>
        </div>
    </section>
</main>

@section('page-script')
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
</script>
@stop
@endsection
