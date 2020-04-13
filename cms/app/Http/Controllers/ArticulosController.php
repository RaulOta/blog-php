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

        return view('paginas.articulos', array("blog"=>$blog, "administradores"=>$administradores));

    }

}
