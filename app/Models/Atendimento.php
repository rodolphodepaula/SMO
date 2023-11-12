<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $table = 'atendimento';
    protected $fillable = [
        'data_atendimento',
        'trabalhoaltura',
        'espacoconfinado',
        'apto',
        'coordenador_id',
        'empregado_id',
        'setor_id',
        'funcao_id',
        'grupo_id',
        'tipoatendimento_id',
    ];
    public $timestamps = false;

    public function empregado()
    {
        return $this->belongsTo('App\Models\Empregado');
    }

    public function tipoatendimento()
    {
        return $this->belongsTo('App\Models\TipoAtendimento');
    }

    public function coordenador()
    {
        return $this->belongsTo('App\Models\Coordenador');
    }


    use HasFactory;
}