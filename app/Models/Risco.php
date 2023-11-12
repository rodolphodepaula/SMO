<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risco extends Model
{
    protected $table = 'risco';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'tiporisco_id'
    ];

    public function tiporisco()
    {
        return $this->belongsTo('App\Models\TipoRisco');
    }
    use HasFactory;

}
