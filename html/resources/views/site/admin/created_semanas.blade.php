@extends('layout_cms.master')
@section('title', 'Semanas concurso')
@section('parentPageTitle', 'Dashboard')
@section('content')
<!-- Basic Examples -->
<div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card user-account">
            <div class="header">
                <h2><strong>Concurso</strong> diario</h2>
                <br>
                <a href="{{route('cms.crear_concurso')}}" title="Validacion de medicos" class="btn btn-round btn-info">Crear semanas del concurso</a>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Inicio de la semana</th>
                                <th>Fin de la semana</th>
                                <th>Status</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semanas as $semana)
                                <tr>
                                    <td style="width: 25px;">{{$semana->id}}</td>
                                    <td style="width: 60px;">{{$semana->start}}</td>
                                    <td style="width: 60px;">{{$semana->end}}</td>
                                    @if($semana->status==1)
                                        <td style="width: 60px;"><strong>Mes activo</strong></td>
                                    @else
                                        <td style="width: 60px;"><strong>Mes inactivo</strong></td>
                                    @endif
                                    <td style="width: 60px;">
                                        <a href="{{route('cms.editsemana.id', $semana->id)}}" class="btn btn-info">Editar Semana</a>
                                         @if($semana->status==1)
                                        <button data-id="{{$semana->id}}" class="btn btn-success week_activate" disabled>Activar semana</button>
                                         @else
                                         <button data-id="{{$semana->id}}" class="btn btn-success week_activate">Activar semana</button>
                                         @endif
                                    </td>
                                </tr>
                            @endforeach()
                        </tbody>
                    </table>
                </div>
                <hr>
                 <div>{!! $semanas->render()!!}</div>
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
<script>
$(document).ready(function(){

       
        $(".week_activate").click(function(event){
            event.preventDefault();
            var id_week = $(this).attr('data-id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ route('cms.activate_week') }}",
                method:'POST',
                dataType: "json",
                data: {
                    id_week: id_week
                },
                success:function(data){
                    if(data.value=='success_active'){
                        location.reload();
                    }
                },
                error: function(resp){
                    console.log('algo salio mal');
                }
            });
        });


        $(".aceptar").click(function(event){
            event.preventDefault();
            var _token = $('meta[name="csrf-token"]').attr('content');
            var valor = $(this).attr('data-value');
            var resultClase =  $(this).attr('class').split(' ');
            var clase = resultClase[2];
            $this = $(this);
            $thisB = this;
            swal({
                title: "¿Estás seguro de aceptar el usuario?",
                text: "¡Estas a punto de aceptar un usuario!",
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
        })

        function AceptarMedico(valor,clase,_token){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ url('cms/alta/medicovalidar')}}",
                method:'POST',
                dataType: "json",
                data: {
                    id_medico: valor,
                    action: clase,
                    _token: _token
                },
                success:function(data){
                    if(data==1){
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
                title: "¿Estás seguro de rechazar el usuario?",
                text: "¡Estas a punto de rechazar al usuario!",
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
                url: "{{ url('cms/alta/medicovalidar')}}",
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