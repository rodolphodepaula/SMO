<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtendimentoExame extends Model
{
    protected $table = 'atendimentoexame';
    protected $fillable = [
        'atendimento_id',
        'exame_id',
    ];
    public $timestamps = false;

    public function exame()
    {
        return $this->belongsTo('App\Models\Exame');
    }
    use HasFactory;
}