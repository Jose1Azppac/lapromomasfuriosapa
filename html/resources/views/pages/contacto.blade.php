@extends('layouts.master')
@section('title') Contacto | Flamin' Hot - La promo más furiosa @endsection

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
                <h3>Contacto</h3>
                <p>Envíanos un mensaje</p>
            </div>
            <!-- // -->
            <!-- // -->
            <div class="cont__fomr f__med">
                <form action="{{route('sendContact')}}" id="contactForm" method="post" autocomplete="off">
                    @csrf
                    <div class="cont__camp">
                        <div class="camp">
                            <label for="nombre">Nombre</label>
                            <div class="c__imp">
                                <input type="text" name="nombre" id="nombre" required placeholder="Nombre *">
                            </div>
                        </div>
                        <div class="camp">
                            <label for="correo">Correo electrónico</label>
                            <div class="c__imp">
                                <input type="email" name="email" id="email" required placeholder="Correo electrónico *">
                            </div>
                        </div>
                        <div class="camp">
                            <label for="mensaje">Mensaje</label>
                            <div class="c__imp">
                                <textarea name="comment" id="comment" required placeholder="Comentario *"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="cont__camp" style="display:none;">
                        <ul class="msn__erro">
                            <li><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Ingresa tu nombre</li>
                            <li><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Ingresa un correo válido</li>
                            <li><span><img src="{{ asset('/img/error.svg') }}" alt=""></span>Escribe un mensaje</li>
                        </ul>
                    </div>
                    <div class="c__cta">
                        <button class="cta cta01" type="submit" id="sendContactBtn"><span>Enviar</span></button>
                    </div>
                </form>
            </div>
            <!-- // -->
        </div>
    </section>
</main>

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
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
<script>
    /**Validacion de formulario de contacto */
    $("#contactForm").validate({
        messages:{
            nombre : {
                required : "Debe de escribir su nombre",
                minlength : "Su nombre debe contener al menos 3 letras"
            },
            email :{
                required : "Debe de escribir su email",
                email:"Debe de escribir un email válido"
            },
            comment : {
                required : "Por favor escriba un mensaje"
            }

        },
        rules:{
            nombre :{
                required : true,
                minlength : 3
            },
            email: {
                required: true,
                email: true
            },
            comment : {
                required: true,
            }
        }
    });

</script>
@stop
@endsection
