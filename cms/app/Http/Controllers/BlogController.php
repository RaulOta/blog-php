<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;

class BlogController extends Controller
{

    /*==================================
    Mostrar todos los registros
    ==================================*/

    public function index()
    {

        $blog = Blog::all();

        return view("paginas.blog", array("blog"=>$blog));

    }

    /*==================================
    Actualizar un registro
    ==================================*/

    public function update($id, Request $request){

        //recoger los datos
        $datos = array("dominio"=>$request->input("dominio"),
                        "servidor"=>$request->input("servidor"),
                        "titulo"=>$request->input("titulo"),
                        "descripcion"=>$request->input("descripcion"),
                        "palabras_claves"=>$request->input("palabras_claves"));

        //Validar los datos

        if(!empty($datos)){

            $validar = \Validator::make($datos, [
                
                "dominio" => 'required|regex:/^[-\\_\\:\\.\\0-9a-z]+$/i',
                "servidor" => 'required|regex:/^[-\\_\\:\\.\\0-9a-z]+$/i',
                "titulo" => 'required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "descripcion" => 'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "palabras_claves" => 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
            
            ]);

            //Revisar la validación
            if ($validar->fails()){
                
                return redirect("/")->with("no-validacion","");

            }else{

                $actualizar = array("dominio" => $datos["dominio"],
                                    "servidor" => $datos["servidor"],
                                    "titulo" => $datos["titulo"],
                                    "descripcion" => $datos["descripcion"],
                                    "palabras_claves" => json_encode(explode(",",$datos["palabras_claves"])));

                $blog = Blog::where("id", $id)->update($actualizar);

                return redirect("/")->with("ok-editar","");

            }

        }else{

            return redirect("/")->with("error","");

        }
    }

}
