<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GrupoExameFormRequest;
use App\Models\Grupo;
use App\Models\GrupoExame;
use App\Models\Exame;
use App\Models\TipoAtendimento;

class GrupoExameController extends Controller
{


private $grupoexame;
private $grupo;
private $exame;
private $tipoAtendimento;

public function __construct(GrupoExame $grupoexame, Grupo $grupo, Exame $exame, TipoAtendimento $tipoAtendimento)
{
    $this->grupoexame = $grupoexame;
    $this->grupo = $grupo;
    $this->exame = $exame;
    $this->tipoAtendimento = $tipoAtendimento;

}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $grupo = $this->grupo->find($id);
        $exames = $this->exame
                ->orderBy('nome','ASC')->get();

        $tipoAtendimentos = $this->tipoAtendimento
                            ->orderBy('nome', 'ASC')->get();

        $grupoexames = $this->grupoexame
                        ->where('grupo_id', '=', $id)
                        ->get();
        return view('admin.grupoexame.index',[
            'grupo' => $grupo,
            'exames' => $exames,
            'tipoatendimentos' => $tipoAtendimentos,
            'grupoexames' => $grupoexames
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoExameFormRequest $request, $id)
    {
         // Pega todos os dados do formulario
         $dataForm = $request->all();

         $grupo = $this->grupo->find($id);

         $exame_id = $dataForm['exame_id'];
         $tipoatendimento_id = $dataForm['tipoatendimento_id'];

         $grupoexame = $this->grupoexame
             ->Where('grupo_id', '=', $id)
             ->Where('exame_id', '=', $exame_id)
             ->Where('tipoatendimento_id', '=', $tipoatendimento_id)
             ->get()->first();

         if ($grupoexame != null){
             return redirect()
                     ->route('grupoexame.index', $id)
                     ->withErrors(['errors' => 'Registro já cadastrado!'])
                     ->withInput();
         }

         $insert = $this->grupoexame->insert([
             'grupo_id' => $id,
             'exame_id' => $exame_id,
             'tipoatendimento_id' => $tipoatendimento_id
         ]);
         if ( $insert )
             return redirect()
                  ->route('grupoexame.index', $id);
         else
             return redirect()
                  ->route('grupoexame.index', $id)
                  ->withErrors(['errors' => 'Erro no Insert'])
                  ->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoExameFormRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupoexame = $this->grupoexame->find($id);
        $grupo_id = $grupoexame->grupo_id;
        $delete = $grupoexame->delete();
        if ( $delete )
            return redirect()
                 ->route('grupoexame.index', $grupo_id)
                 ->withInput();
        else
            return redirect()
                 ->route('grupoexame.index', $grupo_id)
                 ->withErrors(['errors' => 'Erro no Delete'])
                 ->withInput();
    }

}
