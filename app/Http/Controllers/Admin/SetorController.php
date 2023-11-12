<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setor;
use App\Models\GrupoFuncao;
use App\Models\Empregado;
use App\Http\Requests\Admin\SetorFormRequest;

class SetorController extends Controller
{

    private $setor;
    private $empregado;
    private $grupofuncao;

    public function __construct(Setor $setor, Empregado $empregado, GrupoFuncao $grupofuncao)
    {

        $this->setor = $setor;
        $this->empregado = $empregado;
        $this->grupofuncao = $grupofuncao;


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setores = $this->setor
                    ->orderBy('nome', 'ASC')
                    ->paginate(5);

        return view('admin.setor.index', ['setores' => $setores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SetorFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $setor = $this->setor
                    ->where('nome', '=', $nome)
                    ->get()->first();
        if($setor != null){
            return redirect()
                    ->route('setores.create')
                    ->withErrors(['erros' => 'Setor já cadastrada com esse Nome!'])
                    ->withInput();
        }
        //Vai inserir
        $insert = $this->setor->insert([
                'nome' => $dataForm['nome']
        ]);

        if($insert)
        {
            return redirect()
                    ->route('setores.index')
                    ->with(['success' => 'Registro Cadastrado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/setores/create')
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
        $setor = $this->setor->find($id);
        return view('admin.setor.show', ['setor' => $setor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setor = $this->setor->find($id);
        return view('admin.setor.edit', ['setor' => $setor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SetorFormRequest $request, $id)
    {
        $setor = $this->setor->find($id);
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $busca = $this->setor
                    ->where('nome', '=', $nome)
                    ->where('id', '<>', $id)
                    ->get()->first();
        if($busca != null){
            return redirect()
                    ->route('setores.edit', $id)
                    ->withErrors(['erros' => 'Setor já cadastrado com esse Nome!'])
                    ->withInput();
        }
        //Vai alterar
        $update = $setor->update($dataForm);
        if($update)
        {
            return redirect()
                    ->route('setores.index')
                    ->with(['success' => 'Registro Alterado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/setores/Edit', $id)
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
        $setor = $this->setor->find($id);
        $busca = $this->empregado
                    ->where('setor_id', '=', $id)
                    ->get()->count();

        if($busca > 0)
        {
            $message = 'Falha no Delete! Existem '. $busca . ' empregados ligados a este Setor!';
            return redirect()
                ->route('setores.show', $id)
                ->withErrors(['errors' => $message])
                ->withInput();
        }

        $busca = $this->grupofuncao
        ->Where('setor_id', '=', $id)
        ->get()->count();

        if ($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' GrupoFunção ligados a este Setor !';
            return redirect()
                 ->route('setores.show', $id)
                 ->withErrors(['errors' => $message])
                 ->withInput();
        }

        $delete = $setor->delete();
        if($delete)
        {
            return redirect()
                    ->route('setores.index')
                    ->with(['success' => 'Registro excluido com Sucesso'])
                    ->withInput();
        }else{
            return redirect()
                    ->route('setores.show', $id)
                    ->withErrors(['errors' => 'Erro no Delete'])
                    ->withInput();
        }
    }

    public function search(SetorFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $setores = $this->setor->where('nome', 'LIKE', $nome)
                    ->orderBy('nome', 'ASC')
                    ->paginate(5);

        return view('admin.setor.index', ['setores' => $setores, 'dataForm' => $dataForm]);

    }
}
