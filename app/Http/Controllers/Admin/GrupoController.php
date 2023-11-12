<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\GrupoRisco;
use App\Models\GrupoExame;
use App\Models\GrupoFuncao;
use App\Models\Atendimento;
use App\Models\Empregado;
use App\Http\Requests\Admin\GrupoFormRequest;

class GrupoController extends Controller
{

    private $grupo;
    private $gruporisco;
    private $grupoexame;
    private $grupofuncao;
    private $atendimento;
    private $empregado;

    public function __construct(Grupo $grupo, GrupoRisco $gruporisco, GrupoExame $grupoexame, GrupoFuncao $grupofuncao, Atendimento $atendimento, Empregado $empregado)
    {
        $this->grupo = $grupo;
        $this->gruporisco = $gruporisco;
        $this->grupoexame = $grupoexame;
        $this->grupofuncao = $grupofuncao;
        $this->atendimento = $atendimento;
        $this->empregado = $empregado;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupos = $this->grupo
                    ->orderBy('nome', 'ASC')
                    ->paginate(5);
        return view('admin.grupo.index', ['grupos' => $grupos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.grupo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $grupo = $this->grupo
                    ->where('nome', '=', $nome)
                    ->get()->first();
        if($grupo != null){
            return redirect()
                    ->route('grupos.create')
                    ->withErrors(['erros' => 'Grupo já cadastrada com esse Nome!'])
                    ->withInput();
        }
        //Vai inserir
        $insert = $this->grupo->insert([
                'nome' => $dataForm['nome']
        ]);

        if($insert)
        {
            return redirect()
                    ->route('grupos.index')
                    ->with(['success' => 'Registro Cadastrado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/grupos/create')
                    ->withErrors(['erros'=> 'Erro no Insert'])
                    ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grupo = $this->grupo->find($id);
        return view('admin.grupo.show', ['grupo' => $grupo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grupo = $this->grupo->find($id);
        return view('admin.grupo.edit', ['grupo' => $grupo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoFormRequest $request, $id)
    {
        $grupo = $this->grupo->find($id);
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $busca = $this->grupo
                    ->where('nome', '=', $nome)
                    ->where('id', '<>', $id)
                    ->get()->first();
        if($busca != null){
            return redirect()
                    ->route('grupos.edit', $id)
                    ->withErrors(['erros' => 'Grupo já cadastrado com esse Nome!'])
                    ->withInput();
        }
        //Vai alterar
        $update = $grupo->update($dataForm);
        if($update)
        {
            return redirect()
                    ->route('grupos.index')
                    ->with(['success' => 'Registro Alterado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/grupos/Edit', $id)
                    ->withErrors(['erros'=> 'Erro no Update'])
                    ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupo = $this->grupo->find($id);

        //Verifica se existe GrupoExame
        $busca = $this->grupoexame
                    ->where('grupo_id', '=', $id)
                    ->get()->count();

        if($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' GrupoExames ligados a este Grupo!';
            return redirect()
                    ->route('grupos.show', $id)
                    ->withErrors(['errors' => $message])
                    ->withInput();
        }

        //Verifica se existem GrupoRiscos
        $busca = $this->gruporisco
        ->where('grupo_id', '=', $id)
        ->get()->count();

        if($busca > 0){
        $message = 'Falha no Delete! Existem ' . $busca . ' GrupoRiscos ligados a este Grupo!';
        return redirect()
                ->route('grupos.show', $id)
                ->withErrors(['errors' => $message])
                ->withInput();
        }

        //Verifica se existem GrupoFuncoes
        $busca = $this->grupofuncao
        ->where('grupo_id', '=', $id)
        ->get()->count();

        if($busca > 0){
        $message = 'Falha no Delete! Existem ' . $busca . ' GrupoFuncoes ligados a este Grupo!';
        return redirect()
                ->route('grupos.show', $id)
                ->withErrors(['errors' => $message])
                ->withInput();
        }

        //Verifica se existem Atendimentos
        $busca = $this->atendimento
        ->where('grupo_id', '=', $id)
        ->get()->count();

        if($busca > 0){
        $message = 'Falha no Delete! Existem ' . $busca . ' Atendimentos ligados a este Grupo!';
        return redirect()
                ->route('grupos.show', $id)
                ->withErrors(['errors' => $message])
                ->withInput();
        }

        //Verifica se existem Empregados
        $busca = $this->empregado
        ->where('grupo_id', '=', $id)
        ->get()->count();

        if($busca > 0){
        $message = 'Falha no Delete! Existem ' . $busca . ' Empregados ligados a este Grupo!';
        return redirect()
                ->route('grupos.show', $id)
                ->withErrors(['errors' => $message])
                ->withInput();
        }

        $delete = $grupo->delete();
        if($delete)
        {
            return redirect()
                    ->route('grupos.index')
                    ->with(['success' => 'Registro excluido com Sucesso'])
                    ->withInput();
        }else{
            return redirect()
                    ->route('grupos.show', $id)
                    ->withErrors(['errors' => 'Erro no Delete'])
                    ->withInput();
        }


    }
}
