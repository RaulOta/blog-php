<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('plantilla');
});

/*=================================
Rutas para mostrar en la página inicio
=================================*/
/*Route::view('/', 'paginas.blog');
Route::view('/administradores', 'paginas.administradores');
Route::view('/categorias', 'paginas.categorias');
Route::view('/articulos', 'paginas.articulos');
Route::view('/opiniones', 'paginas.opiniones');
Route::view('/banner', 'paginas.banner');
Route::view('/anuncios', 'paginas.anuncios');*/

/*=================================
Ruta para declarar el método y el tipo que se encuentra en el controlador y mostrar en la vista / RUTAS
=================================*/
/*Route::get('/', 'BlogController@traerBlog');
Route::get('/administradores', 'AdministradoresController@traerAdministradores');
Route::get('/articulos', 'ArticulosController@traerArticulos');
Route::get('/categorias', 'CategoriasController@traerCategorias');
Route::get('/banner', 'BannerController@traerBanner');
Route::get('/anuncios', 'AnunciosController@traerAnuncios');
Route::get('/opiniones', 'OpinionesController@traerOpiniones');*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/*================================================
RUTAS QUE INCLUYEN TODOS LOS MÉTODOS HTTP
Route::resource
php artisan route:list
================================================*/

Route::resource('/', 'BlogController');
Route::resource('/blog', 'BlogController');
Route::resource('/administradores', 'AdministradoresController');
Route::resource('/articulos', 'ArticulosController');
Route::resource('/categorias', 'CategoriasController');
Route::resource('/banner', 'BannerController');
Route::resource('/anuncios', 'AnunciosController');
Route::resource('/opiniones', 'OpinionesController');