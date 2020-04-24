@extends('plantilla')

@section('content')

  <div class="content-wrapper" style="min-height: 247px;">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Banner</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

              <li class="breadcrumb-item active">Banner</li>

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

                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearBanner">Crear nuevo banner</button>

                <div class="card-tools">

                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">

                    <i class="fas fa-minus"></i></button>

                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">

                    <i class="fas fa-times"></i></button>

                </div>

              </div>

              <div class="card-body">

                <table class="table table-bored table-striped dt-responsive" id="tablaBanner" width="100%">

                  <thead>

                    <tr>

                      <th width="10px">#</th>
                      <th>Página</th>
                      <th>Título</th>
                      <th>Descripción</th>
                      <th width="200px" >Imágen</th>
                      <th>Fecha</th>
                      <th>Acciones</th>

                    </tr>

                  </thead>

                </table>

                {{-- @foreach ($banner as $element)

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

  {{-- Crear Banner --}}

  <div class="modal" id="crearBanner">

    <div class="modal-dialog modal-sm">

      <div class="modal-content">

        <form action="{{url('/')}}/banner" method="POST" enctype="multipart/form-data">
        
          @csrf

          {{-- Header Modal --}}

          <div class="modal-header bg-info">

            <h4 class="modal-title">Crear Banner</h4>

            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          {{-- Body Modal --}}

          <div class="modal-body">

            {{-- Página Banner --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-list-ul"></i>
              </div>

              <select class="form-control selectPagina" name="pagina_banner" required>

                <option value="">Elige página</option>

                @php
                  $listaBanner = array();
                @endphp

                @foreach ($banners as $key => $value)

                  <?php array_push($listaBanner, $value->pagina_banner); ?>

                @endforeach

                @foreach (array_values(array_unique($listaBanner)) as $key => $value2)

                  <option value="{{$value2}}">{{$value2}}</option>
                    
                @endforeach

              </select>

            </div>

            {{-- Titulo Banner --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-list-ul"></i>
              </div>

              <input type="text" class="form-control titulo_banner" name="titulo_banner" placeholder="Título del banner" disabled required>

            </div>

            {{-- Descripción del Banner --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-pencil-alt"></i>
              </div>

              <input type="text" class="form-control descripcion_banner" name="descripcion_banner" placeholder="Descripción del banner" disabled required>

            </div>

            <hr class="pb-2">

            {{-- Adjuntar imágen Banner --}}

            <div class="form-group my-2 text-center">

              <div class="btn btn-defaul btn-file">

                <i class="fas fa-paperclip"></i>Adjuntar imágen del banner

                <input type="file" name="img_banner" required>

              </div>

              <img class="previsualizarImg_img_banner img-fluid py-2">

              <p class="help-block small">Dimensiones: 1400px * 450px | Peso Max. 2MB | Formato: JPG o PNG</p>

            </div>

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
  Editar registro (Banner)
  ===================================================-->

  @if (isset($status))
    
    @if ($status == 200)

      @foreach ($banner as $key => $value)

        <div class="modal" id="editarBanner">

          <div class="modal-dialog modal-sm">
      
            <div class="modal-content">
      
              <form action="{{url('/')}}/banner/{{$value->id_banner}}" method="POST" enctype="multipart/form-data">
      
                @method('PUT')

                @csrf
      
                <div class="modal-header bg-info">
      
                  <h4 class="modal-title">Editar</h4>
      
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
      
                </div>
      
                <div class="modal-body">

                  {{-- Página del banner --}}
                  <div class="input-group mb-3">

                    <div class="input-group-append input-group-text">
                      <i class="fas fa-list-ul"></i>
                    </div>

                    <select class="form-control selectPagina" name="pagina_banner">
                      
                      <option value="{{$value->pagina_banner}}">{{$value->pagina_banner}}</option>

                      @php
                          $listaBanner = array();
                      @endphp
                      
                      @foreach ($banners as $key => $value2)
                    
                        @php
                            array_push($listaBanner, $value2->pagina_banner);
                        @endphp

                      @endforeach

                      @foreach (array_values(array_unique($listaBanner)) as $key => $value2)
                      
                        @if ($value2 != $value->pagina_banner)

                          <option value="{{$value2}}">{{$value2}}</option>
                            
                        @endif
                      
                      @endforeach

                    </select>

                  </div>

                  @if ($value->pagina_banner == "inicio")

                    {{-- Título del banner --}}

                    <div class="input-group mb-3">

                      <div class="input-group-append input-group-text">
                        <i class="fas fa-list-ul"></i>
                      </div>

                      <input type="text" class="form-control titulo_banner" name="titulo_banner" placeholder="Título del banner" value="{{$value->titulo_banner}}" disabled>

                    </div>

                    {{-- Descripción del banner --}}

                    <div class="input-group mb-3">

                      <div class="input-group-append input-group-text">
                        <i class="fas fa-list-ul"></i>
                      </div>

                      <input type="text" class="form-control descripcion_banner" name="descripcion_banner" placeholder="Descripción de banner" value="{{$value->descripcion_banner}}" disabled>

                    </div>

                    @else

                      {{-- Título del banner --}}

                      <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                          <i class="fas fa-list-ul"></i>
                        </div>

                        <input type="text" class="form-control titulo_banner" name="titulo_banner" placeholder="Título del banner" value="{{$value->titulo_banner}}" required>

                      </div>

                      {{-- Descripción del banner --}}

                      <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                          <i class="fas fa-list-ul"></i>
                        </div>

                        <input type="text" class="form-control descripcion_banner" name="descripcion_banner" placeholder="Descripción de banner" value="{{$value->descripcion_banner}}" required>

                      </div>
                      
                  @endif

                 

                  {{-- Imágen del banner --}}

                  <div class="form-group my-2 text-center">

                    <div class="btn btn-default btn-file">

                      <i class="fas fa-paperclip"></i> Adjuntar imágen del artículo

                      <input type="file" name="img_banner">

                    </div>

                    <img src="{{url('')}}/{{$value->img_banner}}" class="previsualizarImg_img_banner img-fluid py-2">

                    <input type="hidden" value="{{$value->img_banner}}" name="imagen_actual">

                    <p class="help-block small">Dimensiones: 1400px * 450px | Peso Max. 2MB | Formato: JPG o PNG</p>

                  </div>

                </div>
      
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

      <script> $("#editarBanner").modal(); </script>
        
    @endif
      
  @endif

  @if (Session::has("ok-crear"))

    <script>
      notie.alert({ type: 1, text: '¡El banner ha sido creado correctamente!, time: 10'})
    </script>
    
  @endif

  @if (Session::has("no-validacion"))

    <script>
      notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!, time: 10'})
    </script>
      
  @endif

  @if (Session::has("error"))

    <script>
      notie.alert({ type: 3, text: '¡Error en el gestor banner!, time: 10'})
    </script>
      
  @endif

  @if (Session::has("ok-editar"))

  <script>
    notie.alert({ type: 1, text: '¡El banner ha sido editado correctamente!, time: 10'})
  </script>
  
  @endif
  
@endsection