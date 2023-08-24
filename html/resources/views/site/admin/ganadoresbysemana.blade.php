@extends('layout_cms.master')
@section('title', 'reporte posibles ganadores por semana')
@section('parentPageTitle', 'Dashboard')
@section('content')
<!-- Basic Examples -->
<div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card user-account">
            <div class="header">
                <h2><strong>Reportes</strong> por semana</h2>
                <br>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Inicio de la semana</th>
                                <th>Fin de la semana</th>
                                
                                <th>Descargar reporte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semanas_cargadas as $semana)
                                <tr>
                                    <td style="width: 25px;">{{$semana->id}}</td>
                                    <td style="width: 60px;">{{$semana->inicio}}</td>
                                    <td style="width: 60px;">{{$semana->final}}</td>
                                    <td style="width: 60px;">
                                        <a href="{{route('cms.reporte.ganadoresbysemana', $semana->id)}}" class="btn btn-info">Descargar</a>
                                    </td>
                                </tr>
                            @endforeach()
                        </tbody>
                    </table>
                </div>
                
                 
            </div>
               
        </div>
    </div>

<!-- #END# Basic Examples --> 
<div class="row clearfix">
    <div class="col-md-12 col-lg-12">
        <div class="card active-bg">
            <div class="body">
                <p class="copyright m-b-0 text-white">Copyright 2020 © ADV</p>
            </div>
        </div>
    </div>
</div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('cms_front/plugins/sweetalert/sweetalert.css') }}">
@stop

@section('page-script')
<!-- Jquery DataTable Plugin Js --> 
<script src="{{ asset('cms_front/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>

<script src="{{ asset('cms_front/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/js/pages/tables/jquery-datatable.js') }}"></script>
<script src="{{ asset('cms_front/plugins/sweetalert/sweetalert.min.js') }}"></script>
@stop