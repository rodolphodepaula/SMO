<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipousuario_id',
        'status'
    ];

    public function temPermissao($formulario_id, $tipo)
    {
        $user_id = auth()->user()->id;
        $tipousuario_id = auth()->user()->tipousuario_id;
        $sql1 = "SELECT formulario.id, permissao.inclui, permissao.altera, permissao.exclui
                FROM formulario, permissao
            where formulario.id = permissao.formulario_id
            and permissao.formulario_id = '$formulario_id'
            and permissao.tipousuario_id = '$tipousuario_id' ";
        if ($tipo == 'inclui'){
            $sql1 = $sql1 . " and permissao.inclui = true";
        }
        if ($tipo == 'altera'){
            $sql1 = $sql1 . " and permissao.altera = true";
        }
        if ($tipo == 'exclui'){
            $sql1 = $sql1 . " and permissao.exclui = true";
        }
        $permissions = DB::select($sql1);
        if ($permissions == [])
            return false;
        else
            return true;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}