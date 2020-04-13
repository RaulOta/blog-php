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
  
@endsection