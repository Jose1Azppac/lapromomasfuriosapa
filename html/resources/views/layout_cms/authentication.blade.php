<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('cms_front/images/favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', config('app.name'))">
    <meta name="author" content="@yield('meta_author', config('app.name'))">
    @yield('meta')

    @stack('before-styles')

    <link rel="stylesheet" href="{{ asset('cms_front/plugins/bootstrap/css/bootstrap.min.css') }}">

    @stack('after-styles')    
    @if (trim($__env->yieldContent('page-styles')))    
        @yield('page-styles')
    @endif
    
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('cms_front/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('cms_front/css/color_skins.css') }}">
</head>

<?php 
    $setting = !empty($_GET['theme']) ? $_GET['theme'] : '';
    $theme = "theme-cyan";
    $menu = "";
    if ($setting == 'p') {
        $theme = "theme-orange";
    } else if ($setting == 'b') {
        $theme = "theme-blue";
    } else if ($setting == 'g') {
        $theme = "theme-green";
    } else if ($setting == 'c') {
        $theme = "theme-cyan";
    } else if ($setting == 'bl') {
        $theme = "theme-blush";
    } else {
            $theme = "theme-cyan";
    }
?>
    
<body class="<?= $theme ?>">
    
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img class="zmdi-hc-spin" src="{{ asset('cms_front/img/load02.svg') }}" width="48" height="48" alt="InfiniO"></div>
            <p>Espere por favor...</p>        
        </div>
    </div>
    
    <div class="authentication">
        <div class="container">
            @yield('content')
        </div>
        <div id="particles-js"></div>
    </div>

    <!-- Scripts -->
    @stack('before-scripts')

    <script src="{{ asset('cms_front/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('cms_front/bundles/vendorscripts.bundle.js') }}"></script>

    <script src="{{ asset('cms_front/plugins/particles-js/particles.min.js') }}"></script>
    <script src="{{ asset('cms_front/bundles/mainscripts.bundle.js') }}"></script>

    <script src="{{ asset('cms_front/plugins/particles-js/particles.js') }}"></script>
    @stack('after-scripts')
    
</body>
</html>
