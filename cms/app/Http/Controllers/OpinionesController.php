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
        // $categorias = 

        return view("paginas.opiniones", array("blog"=>$blog, "administradores"=>$administradores));

    }
}
