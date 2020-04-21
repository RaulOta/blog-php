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

                @foreach ($banner as $key => $value)

                  <?php array_push($listaBanner, $value->pagina_banner); ?>

                @endforeach

                @foreach (array_values(array_unique($listaBanner)) as $key => $value)

                  <option value="{{$value}}">{{$value}}</option>
                    
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
  
@endsection