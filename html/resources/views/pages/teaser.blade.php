@extends('layouts.master-teaser')
@section('title') ¡Próximamente! | La promo más furiosa @endsection

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
            <div class="flamin">
                <figure class="f__flam">
                    <img src="{{ asset('img/falmes.webp') }}" alt="">
                </figure>
                <figure class="f__logo">
                    <img src="{{ asset('img/logo_hot.webp') }}" alt="">
                </figure>
            </div>
            <!-- // -->
            <div class="txt__anun txt__teaser">
                Prepárate para este gran reto en el que podrás ganar increíbles premios.
            </div>
        </div>
    </section>
</main>

@section('page-script')
<!-- Aqui van los demás scripts -->
<script>
</script>
@stop
@endsection
