@extends('layouts.master')
@section('title') Gracias | La promo más furiosa @endsection

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
                    <figure><img src="{{ asset('img/icon-02.svg') }}" alt=""></figure>
                </div>
                <p class="t__msn">¡Gracias!</p>
                <p class="txt__msn">Tu mensaje se envió con éxito</p>
                <!-- // -->
                <div class="c__cta">
                    <a href="{{route('home')}}" class="cta cta01"><span>Regresar a inicio</span></a>
                    <a href="{{route('faqs')}}" class="cta cta02"><span>Ver FAQ’s</span></a>
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
