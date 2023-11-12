<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoAtendimento;
use App\Models\Atendimento;
use App\Http\Requests\Admin\TipoAtendimentoFormRequest;

class TipoAtendimentoController extends Controller
{



    private $tipoatendimento;
    private $atendimento;

    public function __construct(TipoAtendimento $tipoatendimento, Atendimento $atendimento)
    {
        $this->tipoatendimento = $tipoatendimento;
        $this->atendimento = $atendimento;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoatendimentos = $this->tipoatendimento
                            ->orderBy('nome', 'ASC')->get();

        return view('admin.tipoatendimento.index', ['tipoatendimentos' => $tipoatendimentos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tipoatendimento.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoAtendimentoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $tipoatendimento = $this->tipoatendimento
                    ->where('nome', '=', $nome)
                    ->get()->first();
        if($tipoatendimento != null){
            return redirect()
                    ->route('tipoatendimentos.create')
                    ->withErrors(['erros' => 'Tipo Atendimento já cadastrada com esse Nome!'])
                    ->withInput();
        }
        //Vai inserir
        $insert = $this->tipoatendimento->insert([
                'nome' => $dataForm['nome']
        ]);

        if($insert)
        {
            return redirect()
                    ->route('tipoatendimentos.index')
                    ->with(['success' => 'Registro Cadastrado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/tipoatendimentos/create')
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
        $tipoatendimento = $this->tipoatendimento->find($id);
        return view('admin.tipoatendimento.show', ['tipoatendimento' => $tipoatendimento]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoatendimento = $this->tipoatendimento->find($id);
        return view('admin.tipoatendimento.edit', ['tipoatendimento' => $tipoatendimento]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoAtendimentoFormRequest $request, $id)
    {
        $tipoatendimento = $this->tipoatendimento->find($id);
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $busca = $this->tipoatendimento
                    ->where('nome', '=', $nome)
                    ->where('id', '<>', $id)
                    ->get()->first();
        if($busca != null){
            return redirect()
                    ->route('tipoatendimentos.edit', $id)
                    ->withErrors(['erros' => 'Tipo de Atendimento já cadastrado com esse Nome!'])
                    ->withInput();
        }
        //Vai alterar
        $update = $tipoatendimento->update($dataForm);
        if($update)
        {
            return redirect()
                    ->route('tipoatendimentos.index')
                    ->with(['success' => 'Registro Alterado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/tipoatendimentos/Edit', $id)
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
        $tipoatendimento = $this->tipoatendimento->find($id);
        $busca = $this->atendimento
                    ->where('tipoatendimento_id', '=', $id)
                    ->get()->count();

        if($busca > 0)
        {
            $message = 'Falha no Delete! Existem '. $busca . ' Atendimentos ligados a este Exame!';
            return redirect()
                ->route('tipoatendimentos.show', $id)
                ->withErrors(['errors' => $message])
                ->withInput();
        }

        $delete = $tipoatendimento->delete();
        if($delete)
        {
            return redirect()
                    ->route('tipoatendimentos.index')
                    ->with(['success' => 'Registro excluido com Sucesso'])
                    ->withInput();
        }else{
            return redirect()
                    ->route('tipoatendimentos.show', $id)
                    ->withErrors(['errors' => 'Erro no Delete'])
                    ->withInput();
        }
    }
}
