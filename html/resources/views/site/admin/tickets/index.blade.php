@extends('layout_cms.master')
@section('parentPageTitle', 'Recetas del usuario')
@section('title', 'Recetas del usuario')



@section('sub-action-bar')

@stop


@section('content')
<!-- usuarios -->
@csrf
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Usuarios</strong></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nombre</th>
                                <th>email</th>
                                <th>Fecha registro ticket</th>
                                <th>acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Nombre</th>
                                <th>email</th>
                                <th>Fecha registro ticket</th>
                                <th>acción</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# usuarios --> 
@stop

@section('page-popup')

@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('cms_front/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('cms_front/plugins/sweetalert/sweetalert.css') }}">
@stop

@section('page-script')





<script type="text/javascript">
        
        $(".premio").click(function(event){
            event.preventDefault();
            var _token = $('meta[name="csrf-token"]').attr('content');
            var valor = $(this).attr('data-id');
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
                    RecharzarMedico(valor,_token);
                } else {
                    $this.val("");
                }
            });
        });

        function RecharzarMedico(valor,_token){
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ url('cms/otorgarpremio')}}",
                method:'POST',
                dataType: "json",
                data: {
                    id_receta: valor,
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

    $(function () {

        @if(session()->get('success'))
            showNotification('bg-green', '{{ session()->get('success') }}', 'top', 'center', '', '');  
        @endif

        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
    
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            initComplete: function(settings, json) {
                 $('.sweetalert-button-confirm').on('click', function () {
                    var $userId = $(this).data('id');
                    showConfirmMessage( $userId );
                });
            },
            ajax: "{{ route('tickets.index') }}",
            order: [ [0, 'desc'] ],
            columns: [
                {data: 'id_ticket', name: 'id_ticket'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'fecha_alta_ticket', name: 'fecha_alta_ticket'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                
            ]
        }); 
    });
</script>

<!-- Notification --> 
<script src="{{ asset('cms_front/bundles/libscripts.bundle.js') }}"></script> 
<script src="{{ asset('cms_front/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>
<script src="{{ asset('cms_front/js/pages/ui/notifications.js') }}"></script>

<!-- Jquery Sweet Alert --> 
<script src="{{ asset('cms_front/plugins/sweetalert/sweetalert.min.js') }}"></script>

<!-- Jquery DataTable Plugin Js --> 
<script src="{{ asset('cms_front/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('cms_front/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/js/pages/tables/jquery-datatable.js') }}"></script>
@stop