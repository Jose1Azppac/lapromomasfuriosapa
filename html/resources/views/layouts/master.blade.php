<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-7X1SECPW08"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-7X1SECPW08'); </script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push(

{'gtm.start': new Date().getTime(),event:'gtm.js'}
);var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5PMWBN7');</script>
<!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/img/favicon.png') }}" type="image/x-icon">
    <title>@yield('title')</title>
    <meta http-equiv="Content-type" content="text/html; charset=windows-1252" />
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

    <meta property="og:url"           content="https://www..com/"/>
    <meta property="og:type"          content="website">
    <meta property="og:title"         content=""/>
    <meta property="og:description"   content="">
    <meta property="og:locale"        content="es_MX" />
    <meta property="og:site_name"     content=""/>
    <meta property="og:image"         content="img/thum.jpg">
    <meta property="og:image:width"   content="630"/>
    <meta property="og:image:height"  content="1200"/>

    <!-- Device -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>

    <!-- // CSS -->
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/bootstrap-theme.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/slick.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/slick-theme.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/jquery-ui.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/main.css') }}">

</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5PMWBN7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <!-- // Loader -->
    @include('modules.mod-loader')
    <!-- // Loader -->
    <!-- // Wrapper -->
    <div class="wrapper" id="{{Request::route()->getName()??'default'}}">
        <!-- // Header -->
        @include('modules.header')
        <!-- // Header -->
        <!-- // Main -->
        @yield('content')
        <!-- // Main -->
        <!-- // Footer -->
        @include('modules.footer')
        <!-- // Footer -->
    </div>
    <!-- // Wrapper -->
    <!-- Scripts -->
    @stack('before-scripts')
    <!-- // JS -->
    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/gsap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ScrollMagic.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/debug.addIndicators.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/TweenMax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/TweenLite.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/animation.gsap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/slick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/footer.js') }}"></script>
    <script>
        //Init scrollMagic
        var controller = new ScrollMagic.Controller();

    </script>
    <script>
        //Init scrollMagic
        var controller = new ScrollMagic.Controller();
        var pais = "pa";
        var domainEnv = "{{env('APP_URL')}}";
    </script>
    <!-- // JS -->
    @stack('after-scripts')

    @if (trim($__env->yieldContent('page-script')))
        @yield('page-script')
    @endif

</body>
</html>
