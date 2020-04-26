<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anuncios;
use App\Blog;
use App\Administradores;

class AnunciosController extends Controller
{
    public function index() {

        if(request()->ajax()){

            return dataTables()->of(Anuncios::all())
            ->addColumn('cont_anuncio', function($data){

                $cont_anuncio = '<div class="card collapsed-card">

                                    <div class="card-header">

                                        <h3 class="card-title">Ver contenido</h3>

                                        <div class="card-tools">
                                        
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                        </div>

                                    </div>

                                    <div class="card-body">'.$data->codigo_anuncio.'</div>

                                 </div>';

                return $cont_anuncio;

            })
            ->addColumn('acciones', function($data){

                $acciones = '<div class="btn-group">
                
                                <a href="'.url()->current().'/'.$data->id_anuncio.'" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt text-white"></i>
                                </a>

                                <button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_anuncio.'" method="DELETE" pagina="anuncios" token="'.csrf_token().'">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            </div>';

                return $acciones;

            })
            ->rawColumns(['acciones', 'cont_anuncio'])
            ->make(true);

        }

        $anuncios = Anuncios::all();
        $blog = Blog::all();
        $administradores = Administradores::all();

        return view("paginas.anuncios", array("anuncios"=>$anuncios, "blog"=>$blog, "administradores"=>$administradores));

    }

    /*==============================================
    Crear registro (anuncio)
    ==============================================*/

    public function store(Request $request){

        // Recoger los datos

        $datos = array("pagina_anuncio"=>$request->input("pagina_anuncio"),
                     "codigo_anuncio"=>$request->input("codigo_anuncio"));

        $anuncios = Anuncios::all();

        if(!empty($datos)){

            // Validar página anuncio

            $listaAnuncios = array();
            $banderaAnuncios = 0;

            foreach($anuncios as $key => $value){

                array_push($listaAnuncios, $value->pagina_anuncio);

            }

            foreach(array_values(array_unique($listaAnuncios)) as $key => $value){

                if($datos["pagina_anuncio"] === $value){

                    $banderaAnuncios = 1;

                    break;

                }

            }

            if($banderaAnuncios != 1){

                return redirect("/anuncios")->with("no-validacion", "");

            }

            // Validar código anuncio

            $validarCodigo = \Validator::make($datos, [

                "codigo_anuncio" => 'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'

            ]);

            if($validarCodigo->fails()){

                return redirect("/anuncios")->with("no-validacion", "");

            }

            // Mover todos los ficheros temporales al destino final

            $origen = glob('img/temp/anuncios/*');

            foreach($origen as $fichero){

                copy($fichero, "img/anuncios/".substr($fichero, 18));
                unlink($fichero);

            }

            $blog = Blog::all();

            $anuncio = new Anuncios();
            $anuncio->pagina_anuncio = $datos["pagina_anuncio"];
            $anuncio->codigo_anuncio = str_replace('src="'.$blog[0]["servidor"].'img/temp/anuncios', 'src="'.$blog[0]["servidor"].'img/anuncios', $datos["codigo_anuncio"]);

            $anuncio->save();

            return redirect("anuncios")->with("ok-crear", "");

        }else{

            return redirect("anuncios")->with("error", "");

        }

    }

    /*==============================================
    Mostrar solo un registro
    ==============================================*/

    public function show($id){

        $anuncio = Anuncios::where("id_anuncio", $id)->get();
        $anuncios = Anuncios::all();
        $blog = Blog::all();
        $administradores = Administradores::all();

        if(count($anuncio) != 0){

            return view("paginas.anuncios", array("status" => 200, "anuncio" => $anuncio, "anuncios" => $anuncios, "blog" => $blog, "administradores"=>$administradores));
            
        }else{

            return view("paginas.anuncios", array("status" => 404, "blog" => $blog, "administradores" => $administradores));

        }

    }

    /*==============================================
    Editar registro (anuncio)
    ==============================================*/

    public function update($id, Request $request){

        // Recoger los datos

        $datos = array("pagina_anuncio"=>$request->input("pagina_anuncio"),
                       "codigo_anuncio"=>$request->input("codigo_anuncio")
                );

        $anuncios = Anuncios::all();
        $blog = Blog::all();

        if(isset($datos)){

            // Validar página anuncio

            $banderaPagina = 0;

            $listaPagina = array();

            foreach($anuncios as $key => $value){

                array_push($listaPagina, $value->pagina_anuncio);

            }

            foreach(array_values(array_unique($listaPagina)) as $key => $value){

                if($datos["pagina_anuncio"] === $value){

                    $banderaPagina = 1;

                break;

                }

            }

            if($banderaPagina != 1){

                return redirect("anuncios")->with("no-validacion", "");

            }

            // Validar cógigo anuncio

            $validarCodigo = \Validator::make($datos, [
            
                "codigo_anuncio" => 'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'

            ]);

            if($validarCodigo->fails()){

                return redirect("anuncios")->with("no-validacion", "");

            }
            
            // Mover todos los ficheros temporales al destino final

            $origen = glob('img/temp/anuncios/*');

            foreach($origen as $fichero){

                copy($fichero, "img/anuncios/".substr($fichero, 18));
                unlink($fichero);

            }

            $datos = array("pagina_anuncio" => $datos["pagina_anuncio"],
                           "codigo_anuncio" => str_replace('src="'.$blog[0]["servidor"].'img/temp/anuncios', 'src="'.$blog[0]["servidor"].'img/anuncios', $datos["codigo_anuncio"]));

            $anuncio = Anuncios::where('id_anuncio', $id)->update($datos);

            return redirect("anuncios")->with("ok-editar", "");

        }else{

            return redirect("anuncios")->with("error", "");

        }

    }

    // Eliminar registro (anuncio)

    public function destroy($id, Request $request){

        $validar = Anuncios::where("id_anuncio", $id)->get();

        if(!empty($validar)){

            $anuncio = Anuncios::where("id_anuncio", $validar[0]["id_anuncio"])->delete();

            return "ok";

        }else{

            return redirect("/anuncios")->with("no-borrar", "");

        }

    }

}
