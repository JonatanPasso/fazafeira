<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaDesejos extends Model
{
    public $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'lista_desejos';

    protected $fillable = [
        'usuario',
        'produto',
    ];

    public static function listaProdutoPorId($request)
    {
        return self::where('produto', $request->id)
            ->with('criadoPor')
            ->get();
    }

    public function criadoPor()
    {
        return $this->hasOne(User::class, 'id', 'usuario');
    }

    public function listaDesejos()
    {
        return $this->hasOne(Produto::class, 'id', 'produto');
    }
}
