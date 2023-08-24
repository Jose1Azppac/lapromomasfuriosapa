@extends('layouts.master')
@section('title') Perfil | La promo más furiosa @endsection

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
                <h3>Mi perfil</h3>
            </div>
            <!-- // -->
            <!-- // -->
            <div class="fil__perf">
                <div class="col__perf c01">
                    <div class="i__perf">
                        <figure><img src="{{ asset('img/icon-06.svg') }}" alt=""></figure>
                    </div>
                    <h3 class="usr__name">{{ Auth::user()->full_name}}</h3>
                    <hr>
                    <div class="puntos">Puntos totales</div>
                    <span class="total__p">{{$puntos_globales ?? 0}} pts.</span>
                </div>
                <div class="col__perf c02">
                    <div class="c__cta btn__rank scrll">
                        <div>
                            <!--<a href="" class="cta cta01"><span>Diario</span></a>-->
                            <a href="" class="cta cta02"><span>Bloques</span></a>
                            <!--<a href="" class="cta cta02"><span>Quincenal</span></a>-->
                        </div>
                    </div>
                    <div class="cont__sem scrll">
                        <div>
                            @foreach($weeks as $week)
                                @if($week->status == 1)
                                <a href="{{route('perfil',['week'=>$week->id])}}" class="active">Bloque {{$week->id}}</a>
                                @else
                                <a href="{{route('perfil',['week'=>$week->id])}}">Bloque {{$week->id}}</a>
                                @endif
                            @endforeach
                            <!--<a href="">Semana 02</a>
                            <a href="">Semana 03</a>
                            <a href="">Semana 04</a>
                            <a href="">Semana 05</a>
                            <a href="">Semana 06</a>
                            <a href="">Semana 07</a>
                            <a href="">Semana 08</a>
                            <a href="">Semana 09</a>-->
                        </div>
                    </div>
                    <div class="cont__tab">
                        <table>
                            <thead>
                                <tr>
                                    <td>Fecha de registro</td>
                                    <td>Código</td>
                                    <td>Producto</td>
                                    <td>Puntos</td>

                                </tr>
                            </thead>
                            <tbody>
                               @foreach($codigos_puntuacion as $codigo_puntuacion)
                                    <tr>
                                        <td>{{ $codigo_puntuacion->date}} {{$codigo_puntuacion->month}} {{$codigo_puntuacion->year }}</td>
                                        <td>{{ $codigo_puntuacion->code }}</td>
                                        <td>{{ $codigo_puntuacion->producto ?? 'Tortrix'}}</td>
                                        <td>{{ $codigo_puntuacion->total_score }}</td>

                                    </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="c__cta">
                        <a href="{{route('registrar-codigo')}}" class="cta cta01"><span>Ingresar código</span></a>
                    </div>
                </div>
            </div>
            <!-- // -->
        </div>
    </section>
</main>
<!-- // LB -->
<div class="cont__lb">
    <div class="lb__msn lb01" id="delete" style="display: none;">
        <div class="lb__center">
            <div class="cen__info">
                <div class="info__lb">
                    <div class="container">
                        <!-- // -->
                        <div class="h__sect">
                            <h4>¿Seguro que quieres eliminar tu cuenta?</h4>
                        </div>
                        <!-- // -->
                        <div class="msn__lb">
                            <p>Los datos registrados se perderán.</p>
                        </div>
                        <div class="c__cta">
                            <button class="cta cta01" id="EliminarCuenta" data-id="{{Auth::id()}}"><span>Sí, eliminar cuenta</span></button>
                            <button class="cta cta02 clos__lb"><span>Cancelar</span></button>
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
