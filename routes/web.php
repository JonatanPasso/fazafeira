<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@vueroute');
Route::get('/produto', 'HomeController@index');
Route::get('/listar-produtos', 'ProdutoController@listarProdutos');
Route::get('/listar-produtos-usuario', 'ProdutoController@listarProdutosUsuario');
Route::get('/lista-produto-por-id', 'ProdutoController@listarProdutoPorId');
Route::get('/listar-desejos', 'ProdutoController@listarDesejos');
Route::post('/incluir-produto', 'ProdutoController@incluirProduto');
Route::post('/incluir-lista-desejo', 'ProdutoController@incluirListaDesejo');
Route::post('/alterar-dados-produto', 'ProdutoController@alterarDadosProduto');
Route::post('/excluir-produto', 'ProdutoController@excluirProduto');
Route::post('/excluir-desejo', 'ProdutoController@excluirDesejo');
