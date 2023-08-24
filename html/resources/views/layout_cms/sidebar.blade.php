<aside id="leftsidebar" class="sidebar h_menu">
    <div class="container">
        <div class="row clearfix">
            <div class="col-12">
                <div class="menu">
                    <ul class="list">
                        <li class="header">MAIN</li>

                        <li class="{{ Request::segment(2) === 'index' ? 'active open' : null }}"><a href="{{route('cms.semanas')}}"><i class="icon-speedometer"></i><span>Semanas del concurso</span></a></li>


                        <li class="{{ Request::segment(2) === 'index' ? 'active open' : null }}"><a href="{{route('participantes.index')}}"><i class="icon-speedometer"></i><span>Participantes</span></a></li>

                        <li class="{{ Request::segment(1) === 'app' ? 'active open' : null }}">
                            <a href="javascript:void(0);" class="menu-toggle"><i class="icon-grid"></i><span>Tickets</span></a>
                            <ul class="ml-menu">
                                
                                <li class="{{ Request::segment(2) === 'chat' ? 'active' : null }}"><a href="{{route('tickets.index')}}">Tickets pendientes</a></li>
                                
                                <li class="{{ Request::segment(2) === 'chat' ? 'active' : null }}"><a href="{{route('tickets.validos')}}">Tickets validados</a></li> 

                                <li class="{{ Request::segment(2) === 'chat' ? 'active' : null }}"><a href="{{route('tickets.novalidos')}}">Tickets rechazados</a></li>                             
                            </ul>
                        </li>

                        

                       


                       <!--  <li class="{{ Request::segment(2) === 'chat' ? 'active' : null }}"><a href="#"><i class="icon-grid"></i><span>Tickets</span></a></li> -->

                       <!--  <li class="{{ Request::segment(2) === 'chat' ? 'active' : null }}"><a href="#"><i class="icon-grid"></i><span>Usuarios</span></a></li> -->
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>