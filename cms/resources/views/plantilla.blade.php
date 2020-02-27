<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog del viajero | CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--===================================================
    PLUGINS DE CSS
    ====================================================-->

    {{-- BOOTSTRAP 4 --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    {{-- OverlayScrollbars.min.css --}}
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/OverlayScrollbars.min.css">

    {{-- CSS AdminLTE --}}
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/adminlte.min.css">

    {{-- google fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/OverlayScrollbars.min.css">

    <!--===================================================
    PLUGINS DE JS
    ====================================================-->

    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/19de2e2513.js" crossorigin="anonymous"></script>
    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    {{-- JS AdminLTE --}}
    <script src="{{ url('/') }}/js/plugins/adminlte.js"></script>


</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        @include('modulos.header')

        @include('modulos.sidebar')

        @include('paginas.inicio')

        @include('modulos.footer')

    </div>
    
</body>
</html>