<?php

namespace App\Http\Controllers;

use App\ListaDesejos;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function incluirProduto(Request $request)
    {

        $produto = new Produto();

        $produto->descricao = $request->descricao;
        $produto->categoria = $request->categoria;
        $produto->peso = $request->peso;
        $produto->valor = $request->valor;
        $produto->criado_por = Auth::user()->id;


        $validated = validator($produto->toArray(), [
            'descricao' => 'required',
        ]);

        if ($validated->fails()) {
            return response($validated->errors()->toArray(), 404);
        }

        \DB::beginTransaction();

        $produto->save();

        \DB::commit();

        return $produto;
    }

    public function listarProdutos()
    {
        $produtos = Produto::with('listaDesejos')
            ->with('criadoPor')
            ->get()
            ->toJson(JSON_PRETTY_PRINT);
        return response($produtos, 200);
    }

    public function listarDesejos()
    {
        $lista = ListaDesejos::with('listaDesejos')
            ->with('criadoPor')
            ->get()
            ->toJson(JSON_PRETTY_PRINT);
        return response($lista, 200);
    }

    public function listarProdutosUsuario()
    {
        $produtos = Produto::with('criadoPor')
            ->with('listaDesejos')
            ->get()
            ->where('criado_por', Auth::user()->id)
            ->toJson(JSON_PRETTY_PRINT);
        return response($produtos, 200);
    }

    public function listarProdutoPorId(Request $request)
    {
        return Produto::listaProdutoPorId($request);
    }

    public function alterarDadosProduto(Request $request)
    {
        $produto = Produto::listaProdutoPorId($request);

        $produto->descricao = $request['descricao'];
        $produto->categoria = $request['categoria'];
        $produto->peso = $request['peso'];
        $produto->valor = $request['valor'];

        \DB::beginTransaction();

        $produto->save();

        \DB::commit();

        return $produto;
    }

    public function excluirProduto(Request $request)
    {
        $produto = Produto::listaProdutoPorId($request);

        \DB::beginTransaction();

        $produto->delete();

        \DB::commit();

        return $produto;
    }

    public function excluirDesejo(Request $request)
    {
        $produto = ListaDesejos::listaProdutoPorId($request);

        \DB::beginTransaction();

        $produto->delete();

        \DB::commit();

        return $produto;
    }

    public function incluirListaDesejo(Request $request)
    {
        $produto = new ListaDesejos();

        $produto->usuario = $request['criado_por'];
        $produto->produto = $request['produto_id'];

        \DB::beginTransaction();

        $produto->save();

        \DB::commit();

        return $produto;
    }
}
