@extends('layouts.master')
@section('title') Cambiar contraseña | La promo más furiosa @endsection

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
                <h3><span>Cambiar</span> contraseña</h3>
                <p>Ingresa tu nueva contraseña.</p>
            </div>
            <!-- // -->
            <!-- // -->
            <div class="cont__fomr f__min">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="cont__camp">
                        <div class="camp">
                            <label for="new__pass">Contraseña</label>
                            <div class="c__imp">
                                <input type="password" id="new__pass" name="password">
                            </div>
                        </div>
                        <div class="camp">
                            <label for="confirm__pass">Confirmar contraseña</label>
                            <div class="c__imp">
                                <input type="password" id="confirm__pass" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <div class="cont__camp">
                        <ul class="msn__erro">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <li><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>{{ $error }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="c__cta">
                        <button class="cta cta01"><span>Guardar</span></button>
                        <a href="{{route('home')}}" class="cta cta02"><span>Cancelar</span></a>
                    </div>
                </form>
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
