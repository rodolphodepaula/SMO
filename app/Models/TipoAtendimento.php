<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAtendimento extends Model
{
    protected $table = 'tipoatendimento';
    protected $fillable = [
        'nome'
    ];
    public $timestamps = false;
    use HasFactory;

}
