<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 'tipousuario';

    public $timestamps = false;

    protected $fillable = [
        'nome'
    ];
    use HasFactory;
}
