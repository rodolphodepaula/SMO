<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordenador extends Model
{
    protected $table= 'coordenador';
    protected $fillable = [
        'nome',
        'crm',
        'data_inicio',
        'data_fim',
    ];
    public $timestamps = false;
    use HasFactory;
}