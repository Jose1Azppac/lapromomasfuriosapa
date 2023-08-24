@extends('layouts.master')
@section('title') Ranking semanal | La promo más furiosa @endsection

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
                    
                    <a href="{{route('ranking-semanal')}}" class="cta cta01"><span>Bloques</span></a>
                    <a href="{{route('ranking-semanal')}}" class="cta cta02"><span>Global</span></a>
                </div>
            </div>
            <div class="cont__sem scrll">
                <div>
                    <a href="" class="active">Bloque 1</a>
                    
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
                                        <td>
                                            1
                                        </td>
                                        <td>
                                            Fabián Lestido Juanicó
                                        </td>
                                        <td>
                                            700
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            2
                                        </td>
                                        <td>
                                            Blanca Cotelo
                                        </td>
                                        <td>
                                            500
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            3
                                        </td>
                                        <td>
                                            Gatooo Ninja
                                        </td>
                                        <td>
                                            200
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            4
                                        </td>
                                        <td>
                                            Bibiana De Brum
                                        </td>
                                        <td>
                                            110
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            5
                                        </td>
                                        <td>
                                            Dilson Tavares
                                        </td>
                                        <td>
                                            100
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            6
                                        </td>
                                        <td>
                                            Santiago Bustamante
                                        </td>
                                        <td>
                                            100
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            7
                                        </td>
                                        <td>
                                            Carolina Barth
                                        </td>
                                        <td>
                                            100
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            8
                                        </td>
                                        <td>
                                            Eduardo Trasante
                                        </td>
                                        <td>
                                            100
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            9
                                        </td>
                                        <td>
                                            Daniela Fernandez
                                        </td>
                                        <td>
                                            100
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            10
                                        </td>
                                        <td>
                                            Viviana Machado
                                        </td>
                                        <td>
                                            100
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            11
                                        </td>
                                        <td>
                                            Alejandro Bustamante
                                        </td>
                                        <td>
                                            100
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            12
                                        </td>
                                        <td>
                                            Valentina Ferreira
                                        </td>
                                        <td>
                                            80
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            13
                                        </td>
                                        <td>
                                            Neysa Teran
                                        </td>
                                        <td>
                                            80
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            14
                                        </td>
                                        <td>
                                            Bryan Martinez
                                        </td>
                                        <td>
                                            70
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td>
                                            15
                                        </td>
                                        <td>
                                            Daniel Braz Da Luz
                                        </td>
                                        <td>
                                            70
                                        </td>
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
