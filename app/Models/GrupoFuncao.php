<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoFuncao extends Model
{
    protected $table = 'grupofuncao';

    public $timestamps = false;

    protected $fillable = [
        'grupo_id',
        'funcao_id',
        'setor_id'
    ];

    public function funcao()
    {
        return $this->belongsTo('App\Models\Funcao');
    }

    public function funcoes()
    {
        return $this->hasMany(Funcao::class, 'funcao_id');
    }

    public function setor()
    {
        return $this->belongsTo('App\Models\Setor');
    }
    use HasFactory;
}
