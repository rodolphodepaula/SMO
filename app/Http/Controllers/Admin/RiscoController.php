<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Risco;
use App\Models\TipoRisco;
use App\Models\AtendimentoRisco;
use App\Models\GrupoRisco;
use App\Http\Requests\Admin\RiscoFormRequest;

class RiscoController extends Controller
{

    private $risco;
    private $tiporisco;
    private $atendimentorisco;
    private $gruporisco;

    public function __construct(Risco $risco, TipoRisco $tiporisco, AtendimentoRisco $atendimentorisco, GrupoRisco $gruporisco)
    {
        $this->risco = $risco;
        $this->tiporisco = $tiporisco;
        $this->atendimentorisco = $atendimentorisco;
        $this->gruporisco = $gruporisco;


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $riscos = $this->risco
        ->orderBy('nome', 'ASC')
        ->paginate(5);

        return view('admin.risco.index', ['riscos' => $riscos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tiporiscos = $this->tiporisco
                        ->orderBy('nome', 'ASC')->get();
        return view('admin.risco.create', ['tiporiscos' => $tiporiscos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RiscoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        $tiporisco_id = $dataForm['tiporisco_id'];

        //Verifica se o nome já está cadastrado
        $risco = $this->risco
                    ->where('nome', '=', $nome)
                    ->get()->first();
        if($risco != null){
            return redirect()
                    ->route('riscos.create')
                    ->withErrors(['erros' => 'Risco já cadastrada com esse Nome!'])
                    ->withInput();
        }

        // Vai inserir
        $insert = $this->risco->insert([
            'nome' => $dataForm['nome'],
            'tiporisco_id' => $dataForm['tiporisco_id']
        ]);

        if ( $insert )
           return redirect()
           ->route('riscos.index')
           ->with(['success' => 'Registro Cadastrado com Sucesso'])
           ->withInput();
        else
            return redirect('admin/riscos/create')
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
        $risco = $this->risco->find($id);
        $tiporiscos = $this->tiporisco
                        ->orderBy('nome', 'ASC')->get();
        return view('admin.risco.show', ['risco' => $risco, 'tiporiscos' => $tiporiscos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $risco = $this->risco->find($id);
        $tiporiscos = $this->tiporisco
                        ->orderBy('nome', 'ASC')->get();
        return view('admin.risco.edit', ['risco' => $risco, 'tiporiscos' => $tiporiscos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RiscoFormRequest $request, $id)
    {
        $risco = $this->risco->find($id);
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        $tiporisco_id = $dataForm['tiporisco_id'];

        //Verifica se o nome já está cadastrado
        $busca = $this->risco
                    ->where('nome', '=', $nome)
                    ->where('id', '<>', $id)
                    ->get()->first();

        if($busca != null){
            return redirect()
                    ->route('riscos.edit', $id)
                    ->withErrors(['erros' => 'Risco já cadastrado com esse Nome!'])
                    ->withInput();
        }
        //Vai alterar
        $update = $risco->update($dataForm);
        if($update)
        {
            return redirect()
                    ->route('riscos.index')
                    ->with(['success' => 'Registro Alterado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/riscos/Edit', $id)
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
        $risco = $this->risco->find($id);
        $busca = $this->atendimentorisco
                    ->where('risco_id', '=', $id)
                    ->get()->count();

        if($busca > 0)
        {
            $message = 'Falha no Delete! Existem '. $busca . ' Atendimento ligados a esta Risco!';
            return redirect()
                ->route('riscos.show', $id)
                ->withErrors(['errors' => $message])
                ->withInput();
        }

        $busca = $this->gruporisco
        ->Where('risco_id', '=', $id)
        ->get()->count();

        if ($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' Grupo ligados a esta Risco !';
            return redirect()
                 ->route('riscos.show', $id)
                 ->withErrors(['errors' => $message])
                 ->withInput();
        }

        $delete = $risco->delete();
        if($delete)
        {
            return redirect()
                    ->route('riscos.index')
                    ->with(['success' => 'Registro excluido com Sucesso'])
                    ->withInput();
        }else{
            return redirect()
                    ->route('riscos.show', $id)
                    ->withErrors(['errors' => 'Erro no Delete'])
                    ->withInput();
        }
    }

    public function search(RiscoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $riscos = $this->risco->where('nome', 'LIKE', $nome)
                    ->orderBy('nome', 'ASC')
                    ->paginate(5);

        return view('admin.risco.index', ['riscos' => $riscos, 'dataForm' => $dataForm]);
    }
}
