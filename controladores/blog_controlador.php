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
}