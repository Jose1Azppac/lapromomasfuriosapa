@extends('layouts.master')
@section('title') Ranking quincenal | La promo más furiosa @endsection

@section('content')
<main id="ranking">
    <section class="ranking">
        <div class="container">
            <!-- // -->
            <div class="h__sect h__01">
                <h3>
                    <i class="line l01"></i>
                    Ranking
                    <i class="lna"></i>
                    <i class="line l02"></i>
                </h3>
            </div>
            <!-- // -->
            <div class="c__cta btn__rank scrll">
                <div>
                    <a href="{{route('ranking-diario')}}" class="cta cta02"><span>Diario</span></a>
                    <a href="{{route('ranking-semanal')}}" class="cta cta02"><span>Semanal</span></a>
                    <a href="{{route('ranking-quincenal')}}" class="cta cta01"><span>Quincenal</span></a>
                </div>
            </div>
            <div class="cont__tab">
                <table>
                    <thead>
                        <tr>
                            <td>Posición</td>
                            <td>Usuario</td>
                            <td>Puntos</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Susana Santa Maria</td>
                            <td>12458969</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="nota">
                <p>Recuerda que este ranking es de carácter informativo y solo presenta resultados parciales que están sujetos a revisión y validación final.</p>
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
