@extends('layout_cms.master')
@section('parentPageTitle', 'Creacion semana concurso')
@section('title', 'Crear Concurso diario')

@section('content')

<div class="row clearfix"><!-- Evento -->
    <div class="col-lg-12 col-md-12 col-sm-12">
        <form id="form_create_event" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card">
                <div class="header">
                    <h2><strong>Inicio de la semana</strong></h2>
                </div>
                <div class="body">
                    <div class="row clearfix">                           
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="zmdi zmdi-calendar"></i>
                                </span>
                                <input type="date" id="event_start_datetime"  name="event_start_datetime" class="form-control" placeholder="Click para desplegar el calendario">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="header">
                    <h2><strong>Final de la semana</strong></h2>
                </div>
                <div class="body">
                    <div class="row clearfix">                           
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="zmdi zmdi-calendar"></i>
                                </span>
                                <input type="date" id="event_end_datetime"  name="event_end_datetime" class="form-control" placeholder="Click para desplegar el calendario">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-raised btn-primary btn-round waves-effect" id="SubmitConcurso">GUARDAR</button>
         </form>
    </div>
</div><!-- #END# Evento -->
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('cms_front/plugins/bootstrap-select/css/bootstrap-select.css') }}">

<link rel="stylesheet" href="{{ asset('cms_front/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('cms_front/plugins/bootstrap-select/css/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('cms_front/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css') }}">

<link rel="stylesheet" href="{{ asset('cms_front/plugins/dropzone/dropzone.css') }}">


@stop

@section('page-script')
<script src="{{ asset('cms_front/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('cms_front/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('cms_front/plugins/bootstrap-datetimepicker/moment-with-locales.js') }}"></script>
<script src="{{ asset('cms_front/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}"></script>

<script src="{{ asset('cms_front/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/js/pages/forms/basic-form-elements.js') }}"></script>
<script src="{{ asset('cms_front/bundles/mainscripts.bundle.js') }}"></script>

<script>
    $(document).ready(function(){

        $("#SubmitConcurso").click(function(e) {
            e.preventDefault();
            var fecha_inicio = $('#event_start_datetime').val();
            var fecha_final = $('#event_end_datetime').val();
            // console.log(fecha_hora);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('cms.saveweek')}}",
                method:'POST',
                dataType: "json",
                data: {
                    fecha_inicio: fecha_inicio,
                    fecha_final:fecha_final
                },
                success:function(data){
                    //console.log(data.value);
                    if(data==1){
                        location.href="{{route('cms.semanas')}}";
                    }
                },
                error: function(resp){

                }
            });
        });
    });
</script>

@stop
