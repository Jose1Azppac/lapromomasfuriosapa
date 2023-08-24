@extends('layouts.master')
@section('title') Registro exitoso | Flamin' Hot - La promo más furiosa @endsection

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
                <div class="icon">
                    <figure><img src="{{ asset('img/error.svg') }}" alt=""></figure>
                </div>
                <p class="t__msn">Código 503</p>
                <p class="txt__msn">{{$exception->getMessage() ?? 'Servicio no disponible'}}</p>
                <!-- // -->
                <div class="c__cta">
                    <a href="{{route('home')}}" class="cta cta01"><span>Regresar al inicio</span></a>
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
