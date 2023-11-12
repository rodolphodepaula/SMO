<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CoordenadorFormRequest;
use App\Models\Coordenador;
use App\Models\Atendimento;

class CoordenadorController extends Controller
{


    private $coordenador;

    public function __construct(Coordenador $coordenador, Atendimento $atendimento)
    {
        $this->coordenador = $coordenador;
        $this->atendimento = $atendimento;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coordenadores = $this->coordenador
                        ->orderBy('nome', 'ASC')
                        ->get();
        return view('admin.coordenador.index', ['coordenadores' => $coordenadores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coordenador.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CoordenadorFormRequest $request)
    {
        //$dataForm = $request->all();
        $dataForm = $request->except('_token');
        $busca = $this->coordenador
                    ->where('nome', '=', $dataForm['nome'])
                    ->where('crm', '=', $dataForm['crm'])
                    ->where('data_fim', '=', null)
                    ->get()->first();
        if($busca != null){
            return redirect()
                    ->route('coordenadores.create')
                    ->withErrors(['errors' => 'Já existe no cadastro este Nome e CRM!'])
                    ->withInput();
        }
        $insert = $this->coordenador->insert($dataForm);
        if($insert)
            return redirect()
                    ->route('coordenadores.index')
                    ->with(['success' => 'Registro cadastrado com sucesso'])
                    ->withInput();
        else
            return redirect()
                    ->route('coordendores.create')
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
         $coordenador = $this->coordenador->find($id);
        return view('admin.coordenador.show', ['coordenador' => $coordenador]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coordenador = $this->coordenador->find($id);
        return view('admin.coordenador.edit', ['coordenador' => $coordenador]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoordenadorFormRequest $request, $id)
    {
        //$dataForm = $request->all();
        $dataForm = $request->except('_token');
        $coordenador = $this->coordenador->find($id);

        $busca = $this->coordenador
                ->where('nome', '=', $dataForm['nome'])
                ->where('crm', '=', $dataForm['crm'])
                ->where('data_fim', '=', null)
                ->where('id', '<>', $id)
                ->get()->first();
        if($busca != null){
            return redirect()
                    ->route('coordenadores.edit', $id)
                    ->withErrors(['errors' => 'Já existe no cadastro este Nome e CRM!'])
                    ->withInput();
        }

        $update = $coordenador->update($dataForm);

        if($update)
            return redirect()
                    ->route('coordenadores.index')
                    ->with(['success' => 'Registro alterado com sucesso.'])
                    ->withInput();
        else
            return redirect()
                    ->route('coordenadores.edit', $id)
                    ->withErrors(['errors' => 'Erro no Update'])
                    ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coordenador = $this->coordenador->find($id);
        $busca = $this->atendimento
                 ->where('coordenador_id', '=', $id)
                 ->get()->count();

        if($busca > 0){
            $message = 'Falha no Delete! Existem '. $busca . ' Atendimentos ligados a este coordenador !';
            return redirect()
                    ->route('coordenadores.show', $id)
                    ->withErrors(['errors' =>  $message])
                    ->withInput();
        }

        $delete = $coordenador->delete();
        if($delete)
            return redirect()
                    ->route('coordenadores.index')
                    ->with(['success' => 'Registro deletado com sucesso'])
                    ->withInput();
        else
            return redirect()
                    ->route('coordenadores.show', $id)
                    ->withErrors(['errors' => 'Erro no Delete'])
                    ->withInput();

    }
}
