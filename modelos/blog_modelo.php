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

    /*===========================================
    Enviar opinión
    ===========================================*/
    static public function mdlEnviarOpinion($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_art, nombre_opinion, correo_opinion, foto_opinion, contenido_opinion, fecha_opinion, id_adm) 
        VALUES(:id_art, :nombre_opinion, :correo_opinion, :foto_opinion, :contenido_opinion, :fecha_opinion, :id_adm)");
        
        $stmt -> bindParam(":id_art", $datos["id_art"], PDO::PARAM_STR);
        $stmt -> bindParam(":nombre_opinion", $datos["nombre_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":correo_opinion", $datos["correo_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":foto_opinion", $datos["foto_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":contenido_opinion", $datos["contenido_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":fecha_opinion", $datos["fecha_opinion"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_adm", $datos["id_adm"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            
            return "ok";

        }else{

            print_r(Conexion::conectar()->errorInfo());

        }

        $stmt -> close();

        $stmt = null;

    }
}