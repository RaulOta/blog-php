<?php
Class ControladorBlog{

    /*===============================================
    Mostrar contenido tabla blog
    ===============================================*/
    static public function ctrMostrarBlog(){

        $tabla = "blog";
        $respuesta = ModeloBlog::mdlMostrarBlog($tabla);
        return $respuesta;

    }

    /*===============================================
    Mostrar categorias
    ===============================================*/
    static public function ctrMostrarCategorias(){

        $tabla = "categoria";
        $respuesta = ModeloBlog::mdlMostrarCategorias($tabla);
        return $respuesta;

    }

    /*===============================================
    Mostrar articulos y categorías con inner join
    ===============================================*/
    static public function ctrMostrarConInnerJoin($desde, $cantidad, $item, $valor){

        $tabla1 = "categoria";

        $tabla2 = "articulos";

        $respuesta = ModeloBlog::mdlMostrarConInnerJoin($tabla1, $tabla2, $desde, $cantidad, $item, $valor);

        return $respuesta;
    }

    /*===============================================
    Mostrar total articulos
    ===============================================*/
    static public function ctrMostrarTotalArticulos($item, $valor){

        $tabla = "articulos";

        $respuesta =Modeloblog::mdlMostrarTotalArticulos($tabla, $item, $valor);

        return $respuesta;
    }

    /*===============================================
    Mostrar opiniones inner join
    ===============================================*/
    static public function ctrMostrarOpiniones($item, $valor){

        $tabla1 = "opiniones";
        $tabla2= "administradores";

        $respuesta = Modeloblog::mdlMostrarOpiniones($tabla1, $tabla2, $item, $valor);

        return $respuesta;
    }

    /*===============================================
    Enviar Opinión
    ===============================================*/
    static public function ctrEnviarOpinion(){

        if (isset($_POST["nombre_opinion"])){
            
            if (preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["nombre_opinion"]) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["correo_opinion"]) && preg_match('/^[=\\$\\;\\*\\"\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["contenido_opinion"])){
                
                $tabla = "opiniones";
                $datos = array("id_art" => $_POST["id_art"],
                                "nombre_opinion" => $_POST["nombre_opinion"],
                                "correo_opinion" => $_POST["correo_opinion"],
                                "foto_opinion" => "vistas/img/usuarios/default.png",
                                "contenido_opinion" => $_POST["contenido_opinion"],
                                "fecha_opinion" => date('Y-m-d'),
                                "id_adm" => 1
                            );

                $respuesta = ModeloBlog::mdlEnviarOpinion($tabla, $datos);

                return $respuesta;

            }else{

                return "error Primero";

            }

        }

    }
}