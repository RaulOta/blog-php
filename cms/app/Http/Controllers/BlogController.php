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
                        "palabras_claves"=>$request->input("palabras_claves"),
                        "redes_sociales"=>$request->input("redes_sociales"),
                        "logo_actual"=>$request->input("logo_actual"),
                        "portada_actual"=>$request->input("portada_actual"),
                        "icono_actual"=>$request->input("icono_actual"));

        //recoger las imágenes
        $logo = array("logo_temporal"=>$request->file("logo"));
        $portada = array("portada_temporal"=>$request->file("portada"));
        $icono = array("icono_temporal"=>$request->file("icono"));

        //Validar los datos
        if(!empty($datos)){

            $validar = \Validator::make($datos, [
                
                "dominio" => 'required|regex:/^[-\\_\\:\\.\\0-9a-z]+$/i',
                "servidor" => 'required|regex:/^[-\\_\\:\\.\\0-9a-z]+$/i',
                "titulo" => 'required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "descripcion" => 'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "palabras_claves" => 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "redes_sociales" => 'required',
                "logo_actual" => 'required',
                "portada_actual" => 'required',
                "icono_actual" => 'required'
            
            ]);

            //Validar imágenes logo
            if($logo["logo_temporal"] != ""){

                $validarLogo = \Validator::make($logo, [

                    "logo_temporal" => 'required|image|mimes:jpg,jpeg,png|max:2000000'

                ]);

                if($validarLogo->fails()){

                    return redirect("/")->with("no-validacion-imagen", "");

                }

            }

            //Validar imágenes portada
            if($portada["portada_temporal"] != ""){

                $validarPortada = \Validator::make($portada, [

                    "portada_temporal" => 'required|image|mimes:jpg,jpeg,png|max:2000000'

                ]);

                if($validarPortada->fails()){

                    return redirect("/")->with("no-validacion-imagen", "");

                }

            }

            //Validar imágenes icono
            if($icono["icono_temporal"] != ""){

                $validarIcono = \Validator::make($icono, [

                    "icono_temporal" => 'required|image|mimes:jpg,jpeg,png|max:2000000'

                ]);

                if($validarIcono->fails()){

                    return redirect("/")->with("no-validacion-imagen", "");

                }

            }

            //Revisar la validación
            if ($validar->fails()){
                
                return redirect("/")->with("no-validacion","");

            }else{

                //Subir al servidor la imagen logo

                if ($logo["logo_temporal"] != "") {
                    
                    unlink($datos["logo_actual"]);

                    $aleatorio = mt_rand(100,999);

                    $rutaLogo = "img/blog/".$aleatorio.".".$logo["logo_temporal"]->guessExtension();

                    move_uploaded_file($logo["logo_temporal"], $rutaLogo);

                }else{

                    $rutaLogo = $datos["logo_actual"];

                }

                //Subir al servidor la imagen portada

                if ($portada["portada_temporal"] != "") {
                    
                    unlink($datos["portada_actual"]);

                    $aleatorio = mt_rand(100,999);

                    $rutaPortada = "img/blog/".$aleatorio.".".$portada["portada_temporal"]->guessExtension();

                    move_uploaded_file($portada["portada_temporal"], $rutaPortada);

                }else{

                    $rutaPortada = $datos["portada_actual"];
                }

                //Subir al servidor la imagen icono
    
                if ($icono["icono_temporal"] != "") {
                    
                    unlink($datos["icono_actual"]);

                    $aleatorio = mt_rand(100,999);

                    $rutaIcono = "img/blog/".$aleatorio.".".$icono["icono_temporal"]->guessExtension();

                    move_uploaded_file($icono["icono_temporal"], $rutaIcono);

                }else{

                    $rutaIcono = $datos["icono_actual"];

                }

                $actualizar = array("dominio" => $datos["dominio"],
                                    "servidor" => $datos["servidor"],
                                    "titulo" => $datos["titulo"],
                                    "descripcion" => $datos["descripcion"],
                                    "palabras_claves" => json_encode(explode(",",$datos["palabras_claves"])),
                                    "redes_sociales" => $datos["redes_sociales"],
                                    "portada"=>$rutaPortada,
                                    "logo"=>$rutaLogo,
                                    "icono"=>$rutaIcono);

                $blog = Blog::where("id", $id)->update($actualizar);

                return redirect("/")->with("ok-editar","");

            }

        }else{

            return redirect("/")->with("error","");

        }
    }

}
