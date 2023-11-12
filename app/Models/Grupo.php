<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table= 'grupo';
    protected $fillable = [
        'nome',
    ];

    public $timestamps = false;

    use HasFactory;
}
