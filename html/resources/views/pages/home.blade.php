@extends('layouts.master')
@section('title') La promo más furiosa @endsection

@section('content')
<main>
    <!-- // Inicio -->
    @include('modules.mod-inicio')
    <!-- // Inicio -->
    <!-- // Dinamica -->
    @include('modules.mod-dinamica')
    <!-- // Dinamica -->
    <!-- // Premios -->
    @include('modules.mod-premios')
    <!-- // Premios -->
    <!-- // Juego -->
    @if(env('COUNTRY_NOM') == 'ec' || env('COUNTRY_NOM') == 'pe')
    @else
        @include('modules.mod-juego')
    @endif
    <!-- // Juego -->
    <!-- // Ranking -->
    @include('modules.mod-ranking')
    <!-- // Ranking -->
</main>

@section('page-script')
<!-- Aqui van los demás scripts -->
<script>
    window.onload = function() {
        var
        bars = $('.loader div div')
        prom = $('.prom figure')
        loader = $('.loader')

        // Inicio
        name__promo = $('.name__promo figure')
        prod__ini = $('.prod__ini .key__prod .paque img')
        flames = $('.prod__ini .flames img')
        pre__ini = $('.pre__ini figure')

        mas__car = $('.mas__car')
        l__ff = $('.l__ff')
        disclaimer = $('.disclaimer')

        tl = new TimelineLite();
        tl
        .to(loader,.1,{pointerEvents: "none"})
        .to(prom, .8,{y: '100%', delay: .3})
        .staggerFromTo(bars,3,{scaleY:1,},{scaleX:0, ease: Elastic.easeOut.config(1, 0.7)},0.15, '-=.3')

        // Inicio
        .fromTo(name__promo,1,{autoAlpha: 0, y:'-30%'},{autoAlpha: 1, y:'0%', ease: Elastic.easeOut.config(1, 0.7)}, '-=2.5')
        .staggerFromTo(prod__ini,1,{scale:0, y: '40%'},{scale:1, y: '0%', ease: Elastic.easeOut.config(1, 0.7)},0.10, '-=2')
        .fromTo(flames, 1, {scale: 0,}, {scale: 1, ease: Elastic.easeOut.config(1, 0.7)}, '-=1')
        .fromTo(pre__ini,1,{autoAlpha: 0,x:'-100%'},{autoAlpha: 1,x:'0%', ease: Elastic.easeOut.config(1, 0.7)}, '-=.7')
        .fromTo(mas__car,1,{x:'-100%'},{x:'0%', ease: Elastic.easeOut.config(1, 0.7)}, '-=.7')
        .fromTo(l__ff,1,{scale: 0},{scale: 1, ease: Elastic.easeOut.config(1, 0.7)}, '-=.7')
        .fromTo(disclaimer,1,{autoAlpha: 0},{autoAlpha: 1}, '-=.7')
        .to(loader,.1,{autoAlpha: 0, display: 'none'}, '-=.7')
    }

    // Lineas titulos
    $(".h__01").each(function(i) {
        var line = $(this).find(".line");
            lna = $(this).find(".lna");

        tl = new TimelineLite();

        tl
        .staggerFromTo(line, 1, {scaleX:0}, {scaleX:1, rotation: 0, ease: Elastic.easeOut.config(1, 0.7) },0.10)
        .fromTo(lna, .8, {scaleX:0}, {scaleX:1,ease: Elastic.easeOut.config(1, 0.7) }, '-=.8')
      
        new ScrollMagic.Scene({
            triggerElement: this,
            triggerHook: 0.7
        })
        .setTween(tl)
        //.addIndicators()
        .addTo(controller);
    });

    // Pasos
    $(".paso").each(function(i) {
        var info__pas = $(this).find(".info__pas");
            txt__pas = $(this).find(".txt__pas");
            graf__paso = $(this).find(".graf__paso figure");

        tl = new TimelineLite();

        tl
        .fromTo(info__pas, 1, {x: '-20%', autoAlpha: 0}, {x: '0%', autoAlpha: 1, ease: Elastic.easeOut.config(1, 0.7)})
        .fromTo(txt__pas, .8, {autoAlpha: 0}, {autoAlpha: 1}, '-=.6')
        .fromTo(graf__paso, .8, {y: 30, autoAlpha: 0}, {y: 0, autoAlpha: 1, ease: Elastic.easeOut.config(1, 0.7)}, '-=.6')
      
        new ScrollMagic.Scene({
            triggerElement: this,
            triggerHook: 0.7
        })
        .setTween(tl)
        //.addIndicators()
        .addTo(controller);
    });


    var cont__card = $('.cont__card')

    tlsCard = new TimelineLite();
    tlsCard

    .staggerFromTo(cont__card, .7, {autoAlpha:0, scale:.4,}, {autoAlpha:1, scale:1, ease: Elastic.easeOut.config(1, 0.7)},0.10)

    var ourScene = new ScrollMagic.Scene({ triggerElement: ".cont__ani", triggerHook: .7}) 
    .setTween(tlsCard)
    //.addIndicators()
    .addTo(controller);


    $('.s__pre').slick({
        dots: false,
        infinite: true,
        centerMode: true,
        centerPadding: '33%',
        focusOnSelect: true,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
              centerMode: false,
              adaptiveHeight: true
            }
          }
        ],
        prevArrow: $('.prev01'),
        nextArrow: $('.next01'),
        asNavFor: '.s__dots'
    });

    $('.s__dots').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.s__pre',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        arrows: false,
    });

    $('.s__pre').on('beforeChange', function(event, { slideCount: count }, currentSlide, nextSlide){
        let selectors = [nextSlide, nextSlide - count, nextSlide + count].map(n => `[data-slick-index="${n}"]`).join(', ');
        $('.slide-prem').removeClass('slide-prem');
        $(selectors).addClass('slide-prem');
    });

    $('[data-slick-index="0"]').addClass('slide-prem');

</script>
@stop
@endsection
