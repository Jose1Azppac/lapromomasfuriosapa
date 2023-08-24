@extends('layouts.master-fin')
@section('title') La promo más furiosa @endsection

@section('content')
<main class="main__01">
    <!-- // -->
    <div class="bal">
        <span></span>
    </div>
    <!-- // -->
    @include('modules.mod-flamas')
    <section>
        <div class="container">
            <!-- // -->
            <div class="flamin f__fin">
                <figure class="f__flam">
                    <img src="{{ asset('img/falmes.webp') }}" alt="">
                </figure>
                <figure class="f__logo">
                    <img src="{{ asset('img/logo_hot.webp') }}" alt="">
                </figure>
                <div class="txt__fin">
                    <div>
                        <div>La promo ha finalizado</div>
                    </div>
                </div>
            </div>
            <!-- // -->
            <div class="txt__anun">
               Gracias por participar y muchas felicidades a los ganadores, pronto volveremos con más sorpesas.
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

        f__logo = $('.f__logo img')
        f__flam = $('.f__flam img')
        txt__fin = $('.txt__fin > div')
        txt__anun = $('.txt__anun')

        tl = new TimelineLite();
        tl
        .to(prom, .8,{y: '100%', delay: 1})
        .staggerFromTo(bars,3,{scaleY:1,},{scaleX:0, ease: Elastic.easeOut.config(1, 0.7)},0.15, '-=.7')
        .to(loader,.1,{autoAlpha: 0, display: 'none'}, '-=1')


        .fromTo(f__logo,.9,{autoAlpha: 0, scale:.5,},{autoAlpha: 1, scale:1, ease: Elastic.easeOut.config(1, 0.7)}, '-=2.5')
        .fromTo(f__flam,.9,{autoAlpha: 0, scale:.5,},{autoAlpha: 1, scale:1, ease: Elastic.easeOut.config(1, 0.7)}, '-=2.4')

        .fromTo(txt__fin,.9,{autoAlpha: 0, x: -50,},{autoAlpha: 1, x:0, ease: Elastic.easeOut.config(1, 0.7)}, '-=2')
        .fromTo(txt__anun,.9,{autoAlpha: 0, y: 50,},{autoAlpha: 1, y:0, ease: Elastic.easeOut.config(1, 0.7)}, '-=1.8')

    }
</script>
@stop
@endsection
