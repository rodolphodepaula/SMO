<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empregado extends Model
{
    protected $table= 'empregado';
    public $timestamps = false;
    protected $fillable = [
        'nome',
        'cpf',
        'ctps',
        'serie',
        'data_nascimento',
        'data_admissao',
        'data_demissao',
        'setor_id',
        'funcao_id',
        'grupo_id',
    ];

    public function funcao()
    {
        return $this->belongsTo('App\Models\Funcao');
    }

   public function setor()
    {
        return $this->belongsTo('App\Models\Setor');
    }

    use HasFactory;
}