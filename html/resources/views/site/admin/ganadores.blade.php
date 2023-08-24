@extends('layout_cms.master')
@section('title', 'Participaciones')
@section('parentPageTitle', 'Dashboard')
@section('content')
<!-- Basic Examples -->
<div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card user-account">
            <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Numero de ticket</th>
                                <th>Nombre receta</th>
                                <th>Nombre Participante</th>
                                <th>Email</th>
                                <th>Fecha Registro</th>
                                <th>Acciónes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($concursosdiarios as $concursodiario)
                                <tr>
                                    <td style="width: 25px;">{{$concursodiario->id}}</td>
                                    <td style="width: 60px;">{{$concursodiario->ticket_number}}</td>
                                    <td style="width: 60px;">{{$concursodiario->title_recipe}}</td>
                                    <td style="width: 60px;">{{$concursodiario->name}} {{$concursodiario->last_name}}</td>
                                    <td style="width: 60px;">{{$concursodiario->email}}</td>
                                    <td style="width: 60px;">{{$concursodiario->created_at}}</td>
                                    <td style="width: 60px;">
                                        <a class="btn btn-info" href="{{route('cms.show.InfoParticipacion', $concursodiario->id)}}">ver detalle</a>
                                        <!-- <button class="btn btn-success aceptar" data-value="{{$concursodiario->id}}">otorgar premio</button> -->
                                        
                                    </td>
                                </tr>
                            @endforeach()
                        </tbody>
                    </table>
                </div>
                <hr>
                 <div>{!! $concursosdiarios->render()!!}</div>
            </div>
               
        </div>
    </div>

<!-- #END# Basic Examples --> 
<div class="row clearfix">
    <div class="col-md-12 col-lg-12">
        <div class="card active-bg">
            <div class="body">
                <p class="copyright m-b-0 text-white">Copyright 2021 © Saladitas</p>
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
<script>
    $(document).ready(function(){
        $(".aceptar").click(function(event){
            event.preventDefault();
            var _token = $('meta[name="csrf-token"]').attr('content');
            var valor = $(this).attr('data-value');
            var resultClase =  $(this).attr('class').split(' ');
            var clase = resultClase[2];
            $this = $(this);
            $thisB = this;
            swal({
                title: "¿Estás seguro de otorgar el premio ?",
                text: "¡Estas a punto de aceptar la verificación del premio!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#18ce0f",
                confirmButtonText: "Si, Aprobar!",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    AceptarMedico(valor,clase,_token);
                } else {
                    $this.val("");
                }
            });
        });

        function AceptarMedico(valor,clase,_token){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ url('cms/ganadorvalid')}}",
                method:'POST',
                dataType: "json",
                data: {
                    id_medico: valor,
                    action: clase,
                    _token: _token
                },
                success:function(data){
                    if(data.value==1){
                       location.reload();
                    }
                },
                error: function(resp){
                    console.log('algo salio mal');
                }
            });
        }

        $(".rechazar").click(function(evento){
            event.preventDefault();
            var _token = $('meta[name="csrf-token"]').attr('content');
            var valor = $(this).attr('data-value');
            var resultClase =  $(this).attr('class').split(' ');
            var clase = resultClase[2]; 
            $this = $(this);
            $thisB = this;
            swal({
                title: "¿Estás seguro de quitarle el premio al usuario?",
                text: "¡Estas a punto confirmar la eliminación del premio al usuario!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Rechazar!",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    RecharzarMedico(valor,clase,_token);
                } else {
                    $this.val("");
                }
            });
        });

        function RecharzarMedico(valor,clase,_token){
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ url('cms/ganadorrened')}}",
                method:'POST',
                dataType: "json",
                data: {
                    id_medico: valor,
                    action: clase,
                    _token: _token
                },
                success:function(data){
                    if(data==3){
                       location.reload();
                   }
                },
                error: function(resp){
                    console.log('algo salio mal');
                }
            });
        }
    });
</script>

@stop