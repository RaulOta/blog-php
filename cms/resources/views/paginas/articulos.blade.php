@extends('plantilla')

@section('content')

  <div class="content-wrapper" style="min-height: 247px;">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Artículos</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

              <li class="breadcrumb-item active">Artículos</li>

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

                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearArticulo">Crear nuevo artículo</button>

                <div class="card-tools">

                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">

                    <i class="fas fa-minus"></i></button>

                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">

                    <i class="fas fa-times"></i></button>

                </div>

              </div>

              <div class="card-body">

                {{-- <ul>

                  @foreach ($articulos as $key => $value)
                      
                    <li>

                      <h3>{{ $value["titulo_articulo"] }}</h3>
                      <h5>{{ $value->categorias["titulo_categoria"] }}</h5>

                    </li>

                  @endforeach

                </ul> --}}

                <table class="table table-bored table-striped dt-responsive" id="tablaArticulos" width="100%">

                  <thead>

                    <tr>

                      <th width="10px">#</th>
                      <th>Categorías</th>
                      <th width="200px">Portada</th>
                      <th>Título</th>
                      <th>Descripción</th>
                      <th>Palabras Claves</th>
                      <th>Ruta</th>
                      <th width="700px">Contenido</th>
                      <th>Acciones</th>

                    </tr>

                  </thead>

                </table>

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
  Crear Categorías
  ===================================================-->

  <div class="modal" id="crearArticulo">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <form action="{{url('/')}}/articulos" method="POST" enctype="multipart/form-data">

          @csrf
        
          <div class="modal-header bg-info">
            <h4 class="modal-title">Crear Artículo</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          {{-- Modal body --}}
          <div class="modal-body">

            {{-- Título Categoría --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-list-ul"></i>
              </div>

              <select class="form-control" name="id_cat" required>

                <option value="">Elige Categoría</option>

                @foreach ($categorias as $key => $value)

                  <option value="{{$value->id_categoria}}">{{$value->titulo_categoria}}</option>
                    
                @endforeach

              </select>

            </div>

            {{-- Título artículo --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-list-ul"></i>
              </div>

              <input type="text" class="form-control" name="titulo_articulo" placeholder="Ingrese el título del artículo" value="{{old("titulo_articulo")}}" required>

            </div>

            {{-- Descripción artículo --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-pencil-alt"></i>
              </div>
  
              <input type="text" class="form-control" name="descripcion_articulo" placeholder="Ingrese la descripción del artículo" value="{{old("descripcion_articulo")}}" maxlength="220" required>

            </div>

            {{-- Ruta artículo --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-link"></i>
              </div>

              <input type="text" class="form-control inputRuta" name="ruta_articulo" placeholder="Ingrese la ruta del artículo" value="{{old("ruta_articulo")}}" required>

            </div>

            <hr class="pb-2">

            {{-- Palabras claves artículos --}}

            <div class="form-group mb-3">

              <label>Palabras Claves <span class="small">(Separar por comas)</span></label>

              <input type="text" class="form-control" value="artículo" name="p_claves_articulo" data-role="tagsinput" required>

            </div>

            <hr class="pb-2">

            {{-- Adjuntar portada --}}

            <div class="form-group my-2 text-center">

              <div class="btn btn-defaul btn-file">

                <i class="fas fa-paperclip"></i>Adjuntar Imágen del artículo

                <input type="file" name="img_articulo" required>

              </div>

              <img class="previsualizarImg_img_articulo img-fluid py-2">

              <p class="help-block small">Dimensiones: 680px * 400px | Peso Max. 2MB | Formato: JPG o PNG</p>

            </div>

            <hr class="pb-2">

            <textarea name="contenido-articulo" class="form-control summernote-articulos" required></textarea>

          </div>

          <div class="modal-footer">

            <button type="submit" class="btn btn-primary">Guardar</button>

          </div>
        
        </form>

      </div>

    </div>

  </div>

  @if (Session::has("ok-crear"))

    <script>
      notie.alert({ type: 1, text: '¡El artículo ha sido creado correctamente!, time: 10'})
    </script>
      
  @endif

  @if (Session::has("no-validacion"))

    <script>
      notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!, time: 10'})
    </script>
      
  @endif

  @if (Session::has("error"))

    <script>
      notie.alert({ type: 3, text: '¡Error en el gestor de artículos!, time: 10'})
    </script>
      
  @endif
  
@endsection