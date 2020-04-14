<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulos;
use App\Blog;
use App\Administradores;

use Illuminate\Support\Facades\DB;
use App\Categorias;

class ArticulosController extends Controller
{

    public function index()
    {

        $join = DB::table('categoria')->join('articulos', 'categoria.id_categoria','=','articulos.id_cat')->select('categoria.*','articulos.*')->get();
        
        if(request()->ajax()){

            // return datatables()->of(Articulos::all())
            return datatables()->of($join)
            ->addColumn('titulo_categoria', function($data){

                $titulo_categoria = $data->titulo_categoria;

                return $titulo_categoria;

            })
            ->addColumn('p_claves', function($data){

                $tags = json_decode($data->p_claves_articulo, true);

                $p_claves = '<h5>';

                foreach($tags as $key => $value){

                    $p_claves .= '<span class="badge badge-secondary mx-1">'.$value.'</span>';

                }

                $p_claves .= '</h5>';

                return $p_claves;

            })
            ->addColumn('cont_articulo', function($data){

                $cont_articulo = '<div class="card collapsed-card">
                                    
                                    <div class="card-header">

                                        <h3 class="card-title">Ver Contenido</h3>

                                        <div class="card-tools">
                                        
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                        
                                        </div>

                                    </div>

                                    <div class="card-body">'.$data->contenido_articulo.'</div>

                                  </div>';

                return $cont_articulo;

            })
            ->addColumn('acciones', function($data){

                $botones = '<div class="btn-group">

                                <a href="'.url()->current().'/'.$data->id_articulo.'" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt text-white"></i>
                                </a>

                                <button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_articulo.'" method="DELETE" pagina="articulos" token="'.csrf_token().'">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            </div>';

                return $botones;

            })
            ->rawColumns(['titulo_categoria','p_claves','cont_articulo','acciones'])
            ->make(true);

        }
        //$articulos = Articulos::all();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $categorias = Categorias::all();

        return view('paginas.articulos', array("blog"=>$blog, "administradores"=>$administradores, "categorias"=>$categorias));

    }

    public function store(Request $request){

        // Recoger los datos

        $datos = array("id_cat"=>$request->input("id_cat"),
                       "titulo_articulo"=>$request->input("titulo_articulo"),
                       "descripcion_articulo"=>$request->input("descripcion_articulo"),
                       "p_claves_articulo"=>$request->input("p_claves_articulo"),
                       "ruta_articulo"=>$request->input("ruta_articulo"),
                       "imagen_temporal"=>$request->file("img_articulo"),
                       "contenido_articulo"=>$request->input("contenido-articulo"));

        //echo '<pre>'; print_r($datos); echo '</pre>';
        //return;

        // Recoger datos de la BD blog para las rutas de imágenes

        $blog = Blog::all();

        // Validar los datos
        // https://laravel.com/docs/5.7/validation
        if(!empty($datos)){

            $validar = \Validator::make($datos, [

                "titulo_articulo" => "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "descripcion_articulo" => 'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "p_claves_articulo" => "required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "ruta_articulo" => "required|regex:/^[a-z0-9-]+$/i",
                "imagen_temporal" => "required|image|mimes:jpg,jpeg,png|max:2000000",
                "contenido_articulo" => 'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'

            ]);

            // Guardar artículo

            if(!$datos["imagen_temporal"] || $validar->fails()){

                return redirect("articulos")->with("no-validacion", "");

            }else{

                //Creamos el directorio donde guardamos las imágenes del artículo

                $directorio = "img/articulos/".$datos["ruta_articulo"];

                if(!file_exists($directorio)){

                    mkdir($directorio, 0755); //Crea directorios (0755) una carpeta con todos los permisos

                }

                $aleatorio = mt_rand(100,999);

                $ruta = $directorio."/".$aleatorio.".".$datos["imagen_temporal"]->guessExtension();

                // Redimensionar Imágen

                list($ancho, $alto) = getimagesize($datos["imagen_temporal"]);

                $nuevoAncho = 680;
                $nuevoAlto = 400;

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

                // Mover todos los ficheros temporales al destino final
                $origen = glob('img/temp/articulos/*');

                foreach($origen as $fichero){

                    copy($fichero, $directorio."/".substr($fichero, 19));
                    unlink($fichero);

                }

                $articulo = new Articulos();
                $articulo->id_cat = $datos["id_cat"];
                $articulo->titulo_articulo = $datos["titulo_articulo"];
                $articulo->descripcion_articulo = $datos["descripcion_articulo"];
                $articulo->p_claves_articulo = json_encode(explode(",", $datos["p_claves_articulo"]));
                $articulo->ruta_articulo = $datos["ruta_articulo"];
                $articulo->portada_articulo = $ruta;
                $articulo->contenido_articulo = str_replace('src="'.$blog[0]["servidor"].'img/temp/articulos', 'src="'.$blog[0]["servidor"].$directorio, $datos["contenido_articulo"]);
                $articulo->vistas_articulo = 0;

                $articulo->save();

                return redirect("articulos")->with("ok-crear", "");

            }

        }else{

            return redirect("articulos")->with("error", "");

        }
    }

}
