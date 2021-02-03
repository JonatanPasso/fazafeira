<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'produtos';

    protected $fillable = [
        'descricao',
        'categoria',
        'peso',
        'valor',
        'criado_por'
    ];

    public static function listaProdutoPorId($request)
    {
        return self::whereId($request->id)
            ->with('criadoPor')
            ->first();
    }

    /**
     * Relacionamentos
     * ,
     */
    public function criadoPor()
    {
        return $this->hasOne(User::class, 'id', 'criado_por');
    }

    public function listaDesejos()
    {
        return $this->hasOne(ListaDesejos::class, 'produto', 'id');
    }
}
