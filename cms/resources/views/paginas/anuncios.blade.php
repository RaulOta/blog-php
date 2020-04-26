@extends('plantilla')

@section('content')

  <div class="content-wrapper" style="min-height: 247px;">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Anuncios</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

              <li class="breadcrumb-item active">Anuncios</li>

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

                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearAnuncio">Crear nuevo anuncio</button>

                <div class="card-tools">

                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">

                    <i class="fas fa-minus"></i></button>

                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">

                    <i class="fas fa-times"></i></button>

                </div>

              </div>

              <div class="card-body">

                <table class="table table-bored table-striped dt-responsive" id="tablaAnuncios" width="100%">

                  <thead>

                    <tr>

                      <th width="10px">#</th>
                      <th>Página</th>
                      <th>Anuncio</th>
                      <th>Última modificación</th>
                      <th>Acciones</th>

                    </tr>

                  </thead>

                </table>

                {{-- @foreach ($anuncios as $element)
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
  Crear un registro (anuncio)
  ===================================================-->

  <div class="modal" id="crearAnuncio">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <form action="{{url('/')}}/anuncios" method="POST" enctype="multipart/form-data">
        
          @csrf

          {{-- Header Modal --}}

          <div class="modal-header bg-info">

            <h4 class="modal-title">Crear anuncio</h4>

            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          {{-- Body Modal --}}

          <div class="modal-body">

            {{-- Página anuncio --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-list-ul"></i>
              </div>

              <select class="form-control" name="pagina_anuncio" required>

                <option value="">Seleccionar página</option>

                @php

                    $list = array();

                    foreach ($anuncios as $key => $value) {

                      array_push($list, $value->pagina_anuncio);

                    }

                @endphp

                @foreach (array_values(array_unique($list)) as $key => $value)
                  
                  <option value="{{$value}}">{{$value}}</option>

                @endforeach
                
              </select>

            </div>

            <hr class="pb-2">

            {{-- Cógigo anuncio --}}

            <textarea name="codigo_anuncio" class="form-control summernote-anuncios" required></textarea>

          </div>

          {{-- Footer Modal --}}

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

  <!--==================================================
  Editar registro (anuncio)
  ===================================================-->
  @if (isset($status))

    @if ($status == 200)

      @foreach ($anuncio as $key => $value)

        <div class="modal" id="editarAnuncio">

          <div class="modal-dialog modal-lg">

            <div class="modal-content">

              <form action="{{url('/')}}/anuncios/{{$value->id_anuncio}}" method="POST" enctype="multipart/form-data">
              
                @method('PUT')

                @csrf

                {{-- Header Modal --}}

                <div class="modal-header bg-info">

                  <h4>Editar anuncio</h4>

                  <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                {{-- Body Modal --}}

                <div class="modal-body">

                  {{-- Página anuncio --}}

                  <div class="input-group mb-3">

                    <div class="input-group-append input-group-text">
                      <i class="fas fa-list-ul"></i>
                    </div>

                    <select class="form-control" name="pagina_anuncio">

                      <option value="{{$value->pagina_anuncio}}">{{$value->pagina_anuncio}}</option>

                      @php
                          
                          $listaAnuncio = array();

                          foreach ($anuncios as $key => $value2) {
                            
                            array_push($listaAnuncio, $value2->pagina_anuncio);

                          }

                      @endphp

                      @foreach (array_values(array_unique($listaAnuncio)) as $key => $value2)
                          
                          @if ($value->pagina_anuncio != $value2)

                            <option value="{{$value2}}">{{$value2}}</option>
                              
                          @endif

                      @endforeach

                    </select>

                  </div>

                  <hr class="pb-2">

                  {{-- Código anuncio --}}

                  <textarea name="codigo_anuncio" class="form-control summernote-editar-anuncios">{{$value->codigo_anuncio}}</textarea>

                </div>

                {{-- Footer Modal --}}

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

      <script>$("#editarAnuncio").modal()</script>
        
    @endif
      
  @endif

  @if (Session::has("ok-crear"))

  <script>
    notie.alert({ type: 1, text: '¡El anuncio ha sido creado correctamente!', time: 10})
  </script>
  
  @endif

  @if (Session::has("no-validacion"))

    <script>
      notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10})
    </script>
      
  @endif

  @if (Session::has("error"))

    <script>
      notie.alert({ type: 3, text: '¡Error en el gestor anuncios!', time: 10})
    </script>
      
  @endif

  @if (Session::has("ok-editar"))

  <script>
    notie.alert({ type: 1, text: '¡El anuncio ha sido editado correctamente!', time: 10})
  </script>
  
  @endif

  @if (Session::has("no-borrar"))

    <script>
      notie.alert({ type: 3, text: '¡Error al borrar el anuncio!', time: 10})
    </script>
      
  @endif
  
@endsection