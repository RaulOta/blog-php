<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use App\Blog;
use App\Administradores;

class BannerController extends Controller
{

    /*==============================================
    Mostrar y consultar los banners con DataTable
    ==============================================*/

    public function index(){

        if(request()->ajax()){

            return dataTables()->of(Banner::all())
            ->addColumn('acciones', function($data){

                $acciones = '<div class="btn-group">

                                <a href="'.url()->current().'/'.$data->id_banner.'" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt text-white"></i>
                                </a>

                                <button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_banner.'" method="DELETE" pagina="banner" token="'.csrf_token().'">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            </div>';

                return $acciones;

            })
            ->rawColumns(['acciones'])
            ->make(true);

        }

        // $banner = Banner::all();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $banner = Banner::all();

        return view("paginas.banner", array("blog"=>$blog, "administradores"=>$administradores, "banner"=>$banner));

    }

    /*==============================================
    Agregar Banner
    ==============================================*/

    public function store(Request $request){

        // Recoger los datos

        $datos = array("pagina_banner"=>$request->input("pagina_banner"),
                       "titulo_banner"=>$request->input("titulo_banner"),
                       "descripcion_banner"=>$request->input("descripcion_banner"),
                       "imagen_temporal"=>$request->file("img_banner"));

        // Validar los datos
        // https://laravel.com/docs/5.7/validation

        if(!empty($datos)){

            if($datos["titulo_banner"] != "" && $datos["descripcion_banner"] != ""){

                $validarNulos = \Validator::make($datos, [

                    "titulo_banner" => 'required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                    "descripcion_banner" => 'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
    
                ]);

                if($validarNulos->fails()){
            
                    return redirect("/banner")->with("no-validacion", "");
    
                }

            }

            $validarImg = \Validator::make($datos, [

                "imagen_temporal" =>  'required|image|mimes:jpg,jpeg,png|max:2000000'

            ]);

            // Validación para la página del banner

            if($datos["pagina_banner"] != "interno" && $datos["pagina_banner"] != "inicio"){

                return redirect("banner")->with("no-validacion", "");

            }

            // Guardar banner

            if(!$datos["imagen_temporal"] || $validarImg->fails()){
            
                return redirect("/banner")->with("no-validacion", "");

            }else{

                // Creamos el archivo de la imágen

                $aleatorio = mt_rand(100,999);

                $ruta = "img/banner/".$aleatorio.".".$datos["imagen_temporal"]->guessExtension();

                // Redimensionar imágen

                list($ancho, $alto) = getimagesize($datos["imagen_temporal"]);

                $nuevoAncho = 1400;
                $nuevoAlto = 450;

                if($datos["imagen_temporal"]->guessExtension() == "jpeg"){

                    $origen = imagecreatefromjpeg($datos["imagen_temporal"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagejpeg($destino, $ruta);

                }

                if($datos["imagen_temporal"]->guessExtension() == "png"){

                    $origen = imagecreatefrompng($datos["imagen_temporal"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagealphablending($destino, FALSE);
                    imagesavealpha($destino, TRUE);
                    imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagepng($destino, $ruta);

                }

                $banner = new Banner();
                $banner->pagina_banner = $datos["pagina_banner"];
                $banner->titulo_banner = $datos["titulo_banner"];
                $banner->descripcion_banner = $datos["descripcion_banner"];
                $banner->img_banner = $ruta;

                $banner->save();

                return redirect("/banner")->with("ok-crear", "");

            }

        }else{

            return redirect("/banner")->with("error", "");

        }
        

    }
}
