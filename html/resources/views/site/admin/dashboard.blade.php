@extends('layout_cms.master')
@section('title', 'Index')
@section('parentPageTitle', 'Dashboard')
@section('sub-header')

@stop

@section('content')
<div class="row clearfix">
    <div class="col-md-12 col-lg-12">
        <div class="card active-bg">
            <div class="body">
                <p class="copyright m-b-0 text-white">Copyright 2020 © All Rights Reserved. Saladitas Dashboard</p>
            </div>
        </div>
    </div>
</div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('cms_front/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}">
<link rel="stylesheet" href="{{ asset('cms_front/plugins/morrisjs/morris.min.css') }}">
@stop

@section('page-script')
<script src="{{ asset('cms_front/bundles/morrisscripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/bundles/jvectormap.bundle.js') }}"></script>
<script src="{{ asset('cms_front/bundles/knob.bundle.js') }}"></script>

<script src="{{ asset('cms_front/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/js/pages/index.js') }}"></script>
<script src="{{ asset('cms_front/js/pages/widgets/infobox/infobox-1.js') }}"></script>
@stop