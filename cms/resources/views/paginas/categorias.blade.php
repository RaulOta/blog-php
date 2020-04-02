@extends('plantilla')

@section('content')

  <div class="content-wrapper" style="min-height: 247px;">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Categorías</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

              <li class="breadcrumb-item active">Categorías</li>

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

                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearCategoria">Crear nueva categoría

                </button>

              </div>

              <div class="card-body">

                {{--@foreach ($categorias as $element)
                    
                  {{ $element }}

                @endforeach--}}

                <table class="table table-bordered table-striped dt-responsive" id="tablaCategorias" width="100%">

                  <thead>

                    <tr>

                      <th width="10px">#</th>
                      <th>Título</th>
                      <th>Descripción</th>
                      <th>Palabras claves</th>
                      <th>Ruta</th>
                      <th width="200px">Imágen</th>
                      <th>Acciones</th>
  
                    </tr>
  
                  </thead>

                  <tbody>



                  </tbody>

                </table>

              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->

          </div>

        </div>

      </div>

    </section>
    <!-- /.content -->

  </div>

  <!--=========================================
  Crear Categorías
  ==========================================-->
  <div class="modal" id="crearCategoria">

    <div class="modal-dialog">

      <div class="modal-content">

        <form action="{{url('/')}}/categorias" method="POST" enctype="multipart/form-data">
          
          @csrf

          <div class="modal-header bg-info">

            <h4 class="modal-title">Crear Categoría</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <div class="modal-body">

            {{-- Título de la caegoría --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-list-ul"></i>
              </div>

              <input type="text" class="form-control" name="titulo_categoria" placeholder="Ingrese el título de la categoría" value="{{old("titulo_categoria")}}" required>

            </div>

            {{-- Descripción categoría --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-pencil-alt"></i>
              </div>

              <input type="text" class="form-control" name="descripcion_categoria" placeholder="Ingrese la descripción de la categoría" value="{{old("descripcion_categoria")}}" maxlength="30" required>

            </div>

            {{-- Ruta Categoría --}}

            <div class="input-group mb-3">

              <div class="input-group-append input-group-text">
                <i class="fas fa-link"></i>
              </div>

              <input type="text" class="form-control inputRuta" name="ruta_ategoria" placeholder="Ingrese la ruta de la categoría" value="{{old("ruta_categoria")}}" required>

            </div>

            <hr class="pb-2">

            {{-- Palabras claves categorías --}}

            <div class="form-group mb-3">

              <label>Palabras Claves <span class="small">(Separar por comas)</span></label>

              <input type="text" class="form-control" value="categoría" name="p_claves_categoria" data-role="tagsinput" required>

            </div>

            {{-- Imágen de portada --}}

            <hr class="pb-2">

            <div class="form-group my-2 text-center">

              <div class="btn btn-default btn-file">

                <i class="fas fa-paperclip"></i> Adjuntar Imágen de la Categoría

                <input type="file" name="img_categoria" required>

              </div>

              <img class="previsualizarImg_img_categoria img-fluid py-2">

              <p class="help-block small">Dimensiones: 359px * 254px | Peso Max. 2MB | Formato: JPG o PNG</p>

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
  
@endsection
