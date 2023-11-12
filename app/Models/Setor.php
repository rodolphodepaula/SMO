<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $table = 'setor';
    protected $fillable = [
        'nome'
    ];
    public $timestamps = false;
    use HasFactory;
}
