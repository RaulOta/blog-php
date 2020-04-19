<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Opiniones;
use App\Blog;
use App\Administradores;

use Illuminate\Support\Facades\DB;
use App\Articulos;

class OpinionesController extends Controller
{
    public function index()
    {

        $join = DB::table('opiniones')
                        ->join('users','opiniones.id_adm','=','users.id')
                        ->join('articulos','opiniones.id_art','=','articulos.id_articulo')
                        ->select('opiniones.*','articulos.*','users.*')->get();
        // echo '<pre>'; print_r($join); echo '</pre>';
        // return;

        if(request()->ajax()){

            return datatables()->of($join)
            ->addColumn('aprobacion_opinion', function($data){

                if($data->aprobacion_opinion == 1){

                    $aprovacion = '<button class="btn btn-success btn-sm">Aprobado</button>';

                }else{

                    $aprovacion = '<button class="btn btn-danger btn-sm">Por arpobar</button>';
                    
                }

                return $aprovacion;

            })
            ->addColumn('acciones', function($data){

                $botones = '<div class="btn-group">

                                <a href="'.url()->current().'/'.$data->id_opinion.'" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt text-white"></i>
                                </a>

                                <button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_opinion.'" method="DELETE" pagina="opiniones" token="'.csrf_token().'">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            </div>';

                return $botones;

            })
            ->rawColumns(['aprobacion_opinion','acciones'])
            ->make(true);

        }

        //$opiniones = Opiniones::all();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $articulos = Articulos::all();

        return view("paginas.opiniones", array("blog"=>$blog, "administradores"=>$administradores, "articulos"=>$articulos));

    }

    /*==============================================
    Consultar un solo un registro
    ==============================================*/

    public function show($id){

        $opininion = Opiniones::where('id_opinion', $id)->get();
        $articulos = Articulos::all();
        $blog = Blog::all();
        $administradores = Administradores::all();

        if(count($opininion) != 0){

            return view("paginas.opiniones", array("status"=>200, "opinion"=>$opininion, "articulos"=>$articulos, "blog"=>$blog, "administradores"=>$administradores));

        }else{

            return view("paginas.opiniones", array("status"=>404, "blog"=>$blog, "administradores"=>$administradores));

        }

    }

    /*==============================================
    Editar una opinión
    ==============================================*/
    public function update($id, Request $request){

        // Recoger los datos
        
        $datos = array("id_opinion"=>$request->input("id_art"),
                       "nombre_opinion"=>$request->input("nombre_opinion"),
                       "correo_opinion"=>$request->input("correo_opinion"),
                       "foto_opinion"=>$request->input("foto_opinion"),
                       "contenido_opinion"=>$request->input("contenido_opinion"),
                       //"fecha_opinion"=$request->input("fecha_opinion"),
                       "aprobacion_opinion"=>$request->input("aprobacion_opinion"),
                       "id_adm"=>$request->input("id_adm"),
                       "respuesta_opinion"=>$request->input("respuesta_opinion")
                    );

        if(!empty($datos)){

            if($datos["respuesta_opinion"] != ""){

                $validarRespuesta_opinion = \Validator::make($datos, ["respuesta_opinion"=>'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i']);

                if($validarRespuesta_opinion->fails()){

                    return redirect("opiniones")->with("no-validacion", "");

                }

            }

            $validar = \Validator::make($datos, [

                //"id_opinion"=>"required|regex:/^[0-9]+$/i",
                "nombre_opinion"=>"required|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "correo_opinion"=>'required|regex:/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/i',
                "foto_opinion"=>'required',
                "contenido_opinion"=>'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "aprobacion_opinion"=>'required'
                //"id_adm"=>"required"
                // "respuesta_opinion"=>'required|regex:/^[=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'

            ]);

            if(($datos["aprobacion_opinion"] != 1) && ($datos["aprobacion_opinion"] != 0)){

                return redirect("opiniones")->with("no-validacion", "");

            }

            if($validar->fails()){

                return redirect("opiniones")->with("no-validacion", "");

            }else{

                $datos = array("aprobacion_opinion" => $datos["aprobacion_opinion"],
                               "id_adm" => $datos["id_adm"],
                               "respuesta_opinion" => $datos["respuesta_opinion"],
                                "fecha_respuesta" => date('Y-m-d')

                );

                $opinion = Opiniones::where('id_opinion', $id)->update($datos);

                return redirect("opiniones")->with("ok-editar", "");

            }

        }else{

            return redirect("opiniones")->with("error", "");

        }

    }
}
