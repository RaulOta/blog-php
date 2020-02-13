<?php

require_once "conexion.php";

Class ModeloBlog{

    /*======================================
    Mostrar contenido tabla blog
    ======================================*/
    static public function mdlMostrarBlog($tabla){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt -> execute();

        return $stmt -> fetch();

        $stmt -> close();
        $stmt = null;
    }

    /*======================================
    Mostrar categorias
    ======================================*/
    static public function mdlMostrarCategorias($tabla){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt -> execute();

        return $stmt -> fetchAll();

        $stmt -> close();
        $stmt = null;
    }

    /*===========================================
    Mostrar articulos y categorías con inner join
    ===========================================*/

    static public function mdlMostrarConInnerJoin($tabla1, $tabla2, $desde, $cantidad, $item, $valor){

        if($item == null && $valor == null){

            $stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.*, DATE_FORMAT(fecha_articulo, 
            '%d.%m.%Y') AS fecha_articulo FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_categoria = 
            $tabla2.id_cat ORDER BY $tabla2.id_articulo DESC LIMIT $desde, $cantidad");
    
            $stmt -> execute();
    
            return $stmt -> fetchAll();

        }else{

            $stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.*, DATE_FORMAT(fecha_articulo, 
            '%d.%m.%Y') AS fecha_articulo FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_categoria = 
            $tabla2.id_cat WHERE $item = :$item  ORDER BY $tabla2.id_articulo DESC LIMIT $desde, $cantidad");

            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
    
            return $stmt -> fetchAll();

        }


        $stmt -> close();

        $stmt = null;
    }

    /*===========================================
    Mostrar total de articulos
    ===========================================*/

    static public function mdlMostrarTotalArticulos($tabla, $item, $valor){

        if($item == null && $valor == null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

            $stmt -> execute();
    
            return $stmt -> fetchAll();

        }else{

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt -> execute();
    
            return $stmt -> fetchAll();

        }


        $stmt -> close();

        $stmt = null;
    }

    /*===========================================
    Mostrar opiniones
    ===========================================*/

    static public function mdlMostrarOpiniones($tabla1, $tabla2, $item, $valor){

        $stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.* FROM $tabla1 INNER JOIN 
        $tabla2 ON $tabla1.id_adm = $tabla2.id_admin WHERE $item = :$item");

        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

        $stmt -> execute();
    
        return $stmt -> fetchAll();

        $stmt -> close();

        $stmt = null;
    }
}