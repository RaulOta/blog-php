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
}
