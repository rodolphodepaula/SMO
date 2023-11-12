<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtendimentoRisco extends Model
{
    protected $table = 'atendimentorisco';
    protected $fillable = [
        'atendimento_id',
        'risco_id',
    ];
    public $timestamps = false;

     public function risco()
    {
        return $this->belongsTo('App\Models\Risco');
    }
    use HasFactory;
}