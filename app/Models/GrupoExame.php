<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoExame extends Model
{
    protected $table= 'grupoexame';
    protected $fillable = [
        'grupo_id',
        'exame_id',
    ];
    public $timestamps = false;

    public function exame()
    {
        return $this->belongsTo('App\Models\Exame');
    }

    public function tipoatendimento()
    {
        return $this->belongsTo('App\Models\TipoAtendimento');
    }


    use HasFactory;
}
