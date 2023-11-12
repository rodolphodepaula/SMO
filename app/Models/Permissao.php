<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    protected $table= 'permissao';
    protected $fillable = [
        'tipousuario_id',
        'formulario_id',
        'inclui',
        'altera',
        'exclui',
    ];
    public $timestamps = false;

    use HasFactory;


    public function formulario()
    {
        return $this->belongsTo('App\Models\Formulario');
    }

}
