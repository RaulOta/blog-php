@extends('plantilla')

@section('content')

  <div class="content-wrapper" style="min-height: 247px;">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Opiniones</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

              <li class="breadcrumb-item active">Opiniones</li>

            </ol>

          </div>
          
        </div>

      </div><!-- /.container-fluid -->

    </section>

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">

        <div class="row">

          <div class="col-12">

            <!-- Default box -->
            <div class="card">

              <div class="card-header">

                <div class="card-tools">

                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">

                    <i class="fas fa-minus"></i></button>

                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">

                    <i class="fas fa-times"></i></button>

                </div>

              </div>

              <div class="card-body">

                <table class="table table-bored table-striped dt-responsive" id="tablaOpiniones" width="100%">
                  
                  <thead>

                    <tr>

                      <th width="10px">#</th>
                      <th>Artículo</th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th width="200px">Foto</th>
                      <th width="700px">Opinión</th>
                      <th>Fecha Opinión</th>
                      <th>Aprobación</th>
                      <th>Administrador</th>
                      <th>Respuesta</th>
                      <th>ültima modificación</th>
                      <th>Acciones</th>

                    </tr>

                  </thead>

                </table>

                {{-- @foreach ($opiniones as $element)
                    {{ $element }}
                @endforeach --}}


              </div>
              <!-- /.card-body -->

              <div class="card-footer">

                Footer

              </div>
              <!-- /.card-footer-->

            </div>
            <!-- /.card -->

          </div>

        </div>

      </div>

    </section>
    <!-- /.content -->

  </div>

  <!--==================================================
  Editar opiniones
  ===================================================-->

  @if (isset($status))

    @if($status == 200)

    @foreach ($opinion as $key => $value)

      <div class="modal" id="editarOpinion">

        <div class="modal-dialog modal-sm">
    
          <div class="modal-content">
    
            <form action="{{url('/')}}/opiniones/{{$value->id_opinion}}" method="POST" enctype="multipart/form-data">
            
              @method('PUT')

              @csrf

              {{-- Modal Header --}}

              <div class="modal-header bg-info">

                <h4 class="modal-title">Editar Opinion</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              {{-- Modal body --}}

              <div class="modal-body">

                {{-- Foto del autor de la opinón --}}

                <div class="form-group my-2 text-center">

                  <img src="{{url('/')}}/{{substr($value->foto_opinion, 11)}}" class="previsualizarImg_foto img-fluid py-2 w-25 rounded-circle">

                  <input type="hidden" name="foto_opinion" value="{{$value->foto_opinion}}">

                </div>

                {{-- Nombre del autor de la opinion --}}

                <div class="input-group mb-3">

                  <div class="input-group-text">

                    <i class="fas fa-user"></i>

                  </div>

                  <input type="text" class="form-control" name="nombre_opinion" placeholder="Nombre del autor de la opinión" value="{{$value->nombre_opinion}}" readonly>

                </div>

                {{-- Correo del autor de la opinión --}}

                <div class="input-group mb-3">

                  <div class="input-group-text">

                    <i class="fas fa-envelope"></i>

                  </div>

                  <input type="text" class="form-control" name="correo_opinion" placeholder="Ingrese el correo del autor  de la opinión" value="{{$value->correo_opinion}}" readonly>

                </div>

                {{-- Titulo del artículo --}}

                <div class="input-group mb-3">

                  <div class="input-group-append input-group-text">

                    <i class="fas fa-list-ul"></i>

                  </div>

                  @foreach ($articulos as $key => $value2)

                    @if ($value->id_art == $value2->id_articulo)

                      <input type="text" class="form-control" name="titulo_articulo" placeholder="Ingrese el título del artículo" value="{{$value2->titulo_articulo}}" readonly>

                      <input type="hidden" name="id_art" value="{{$value2->id_articulo}}">
                        
                    @endif
                      
                  @endforeach

                </div>

                {{-- Contenido de la opinión --}}

                <label for="contenido_opinion">Comentario</label>

                <textarea name="contenido_opinion" class="form-control" readonly>{{$value->contenido_opinion}}</textarea>

                {{-- Fecha de la opinión --}}

                @php
                    $formatoFC = strtotime($value->fecha_opinion);
                    $formatoFC = date('d.m.y', $formatoFC);

                @endphp

                <div class="text-right">

                  <span class="medium text-right">Fecha de creación: {{$formatoFC}}</span>

                </div>

                <hr class="pb-2">

                {{-- Aprobar opinión --}}

                <div class="input-group mb-3">

                  <div class="input-group-append input-group-text">

                    <i class="fas fa-exchange-alt"></i>

                  </div>

                  <select class="form-control" name="aprobacion_opinion" required>

                    @if ($value->aprobacion_opinion == 1)

                      <option value="{{$value->aprobacion_opinion}}">Aprobada</option>

                      <option value="{{0}}">Desaprobada</option>

                      @else

                        <option value="{{$value->aprobacion_opinion}}">Desaprobada</option>

                        <option value="{{1}}">Aprobada</option>
                        
                    @endif
                    
                  </select>

                </div>

                {{-- Responder a la opinión --}}

                <label for="respuesta_opinion">Respuesta</label>

                <textarea name="respuesta_opinion" class="form-control" placeholder="Escriba aquí su respuesta">{{$value->respuesta_opinion}}</textarea>

                {{-- Fecha de respuesta --}}

                @php

                  if($value->fecha_respuesta != null){

                    $formatoFR = strtotime($value->fecha_respuesta);
                    $formatoFR = date('d.m.y', $formatoFR);

                  }else{

                    $formatoFR = "00.00.00";

                  }

                @endphp

                <div class="text-right">

                  <span class="medium text-right">Última modificación: {{$formatoFR}}</span>
                  
                </div>

                {{-- Nombre del administrador --}}

                <div class="input-group mb-3">

                  <div class="input-group-text">

                    <i class="fas fa-user"></i>

                  </div>

                  @foreach ($administradores as $key => $value2)

                    @if ($value->id_adm == $value2->id)

                    <input type="text" class="form-control" name="nombre_opinion" placeholder="Nombre del autor de la opinión" value="{{$value2->name}}" readonly>
                        
                    @endif

                    @if ($_COOKIE["email_login"] == $value2->email)

                      <input type="hidden" name="id_adm" value="{{$value2->id}}">
                        
                    @endif
                      
                  @endforeach

                </div>

              </div>

              {{-- Modal footer --}}

              <div class="modal-footer d-flex justify-content-between">

                <div>

                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

                </div>

                <div>

                  <button type="submit" class="btn btn-primary">Guardar</button>

                </div>
                
              </div>
            
            </form>
    
          </div>
    
        </div>
    
      </div>
        
    @endforeach

    <script>$('#editarOpinion').modal()</script>
        
    @endif
      
  @endif

  @if (Session::has("ok-editar"))

    <script>
      notie.alert({ type: 1, text: '¡La opinión ha sido ceditado correctamente!, time: 10'})
    </script>
    
  @endif

  @if (Session::has("no-validacion"))

    <script>
      notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!, time: 10'})
    </script>
      
  @endif

  @if (Session::has("error"))

    <script>
      notie.alert({ type: 3, text: '¡Error en el gestor de opiniones!, time: 10'})
    </script>
      
  @endif

  @if (Session::has("error"))

    <script>
      notie.alert({ type: 3, text: '¡Error en el gestor de opiniones!, time: 10'})
    </script>
      
  @endif

  @if (Session::has("no-borrar"))

    <script>
      notie.alert({ type: 3, text: '¡Error, no se borro la opinión!, time: 10'})
    </script>
      
  @endif
  
@endsection