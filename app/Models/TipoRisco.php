<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRisco extends Model
{
    protected $table = 'tiporisco';
    protected $fillable = [
        'nome'
    ];
    public $timestamps = false;
    use HasFactory;
}
