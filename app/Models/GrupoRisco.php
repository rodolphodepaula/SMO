<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoRisco extends Model
{
    protected $table= 'gruporisco';
    protected $fillable = [
        'grupo_id',
        'risco_id',
    ];
    public $timestamps = false;

    public function risco()
    {
        return $this->belongsTo('App\Models\Risco');
    }
    use HasFactory;
}
