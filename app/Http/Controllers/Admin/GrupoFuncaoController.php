<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\GrupoFuncao;
use App\Models\Funcao;
use App\Models\Setor;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\GrupoFuncaoFormRequest;

class GrupoFuncaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $grupofuncao;
    public function __construct(GrupoFuncao $grupofuncao, Grupo $grupo, Setor $setor, Funcao $funcao)
    {
        $this->grupo = $grupo;
        $this->grupofuncao = $grupofuncao;
        $this->funcao = $funcao;
        $this->setor = $setor;
    }

    public function index($id)
    {
        $grupo = $this->grupo->find($id);
        $funcoes = $this->funcao
                ->orderBy('nome', 'ASC')->get();

        $setores = $this->setor
                ->orderBy('nome', 'ASC')->get();

        $grupofuncoes = $this->grupofuncao
                ->Where('grupo_id', '=', $id)
                ->get();

        return view('admin.grupofuncao.index', [
            'grupo' => $grupo,
            'funcoes' => $funcoes,
            'setores' => $setores,
            'grupofuncoes' => $grupofuncoes
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
    public function store(GrupoFuncaoFormRequest $request, $id)
    {
        // Pega todos os dados do formulario
        $dataForm = $request->all();

        $grupo = $this->grupo->find($id);

        $funcao_id = $dataForm['funcao_id'];
        $setor_id = $dataForm['setor_id'];

        $grupofuncao = $this->grupofuncao
            ->Where('grupo_id', '=', $id)
            ->Where('funcao_id', '=', $funcao_id)
            ->Where('setor_id', '=', $setor_id)
            ->get()->first();

        if ($grupofuncao != null){
            return redirect()
                    ->route('grupofuncao.index', $id)
                    ->withErrors(['errors' => 'Registro jรก cadastrado!'])
                    ->withInput();
        }

        $insert = $this->grupofuncao->insert([
            'grupo_id' => $id,
            'funcao_id' => $funcao_id,
            'setor_id' => $setor_id
        ]);
        if ( $insert )
            return redirect()
                 ->route('grupofuncao.index', $id);
        else
            return redirect()
                 ->route('grupofuncao.index', $id)
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
    public function update(Request $request, $id)
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
        $grupofuncao = $this->grupofuncao->find($id);
        $grupo_id = $grupofuncao->grupo_id;
        $delete = $grupofuncao->delete();
        if ( $delete )
            return redirect()
                 ->route('grupofuncao.index', $grupo_id)
                 ->withInput();
        else
            return redirect()
                 ->route('grupofuncao.index', $grupo_id)
                 ->withErrors(['errors' => 'Erro no Delete'])
                 ->withInput();
    }
}
