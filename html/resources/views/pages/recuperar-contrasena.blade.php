@extends('layouts.master')
@section('title') Recuperar contraseña | La promo más furiosa @endsection

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
                <h3><span>Olvide mi</span> contraseña</h3>
                <p>Ingresa el correo electrónico con el que te registraste la primera vez.</p>
            </div>
            <!-- // -->
            <!-- // -->
            <div class="cont__fomr f__min">
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="cont__camp">
                        <div class="camp">
                            <label for="correo">Correo electrónico</label>
                            <div class="c__imp">
                                <input type="text" id="email" name="email">
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <div class="cont__camp">
                            <ul class="msn__erro">
                                <li><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>{{ $message }}</li>
                            </ul>
                        </div>
                    @enderror
                    @if(session('status'))
                        <div class="cont__camp">
                            <ul class="msn__erro">
                                <li><span><img src="{{ asset('/img/icon-09.svg') }}" alt=""></span>{{ session('status') }}</li>
                            </ul>
                        </div>
                    @enderror
                    <div class="c__cta">
                        <button class="cta cta01"><span>Recuperar</span></button>
                    </div>
                </form>
                <div class="c__cta">
                    <p>Si no tienes una cuenta</p>
                    <a href="{{route('registro')}}" class="cta cta02"><span>Regístate aquí</span></a>
                </div>
            </div>
            <!-- // -->
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
