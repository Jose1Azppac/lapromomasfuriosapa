@extends('layouts.master')
@section('title') Registro exitoso | La promo más furiosa @endsection

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
                    <figure><img src="{{ asset('img/icon-01.svg') }}" alt=""></figure>
                </div>
                <p class="t__msn">¡Registro exitoso!</p>
                <p class="txt__msn">Tu registro ha sido completado. <br>¡Ya puedes comenzar a registrar tus códigos para participar!</p>
                <!-- // -->
                <div class="c__cta">
                @if(env('COUNTRY_NOM') == 'ec' || env('COUNTRY_NOM') == 'pe')
                    <a href="{{route('registrar-codigo')}}" class="cta cta01"><span>Ingresar lote</span></a>
                @else
                    <a href="{{route('registrar-codigo')}}" class="cta cta01"><span>Ingresar código</span></a>
                @endif
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
