<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Funcao;
use App\Models\Empregado;
use App\Models\GrupoFuncao;
use App\Http\Requests\Admin\FuncaoFormRequest;

class FuncaoController extends Controller
{

    private $funcao;
    private $empregado;
    private $grupofuncao;

    public function __construct(Funcao $funcao, Empregado $empregado, GrupoFuncao $grupofuncao)
    {
        $this->funcao = $funcao;
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
        $funcoes = $this->funcao->orderBy('nome', 'ASC')->paginate(5);
        return view('admin.funcao.index', ['funcoes' => $funcoes]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.funcao.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuncaoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $funcao = $this->funcao
                    ->where('nome', '=', $nome)
                    ->get()->first();
        if($funcao != null){
            return redirect()
                    ->route('funcoes.create')
                    ->withErrors(['erros' => 'Função já cadastrada com esse Nome!'])
                    ->withInput();
        }
        //Vai inserir
        $insert = $this->funcao->insert([
                'nome' => $dataForm['nome']
        ]);

        if($insert)
        {
            return redirect()
                    ->route('funcoes.index')
                    ->with(['success' => 'Registro Cadastrado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/funcoes/create')
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
        $funcao = $this->funcao->find($id);
        return view('admin.funcao.show', ['funcao' => $funcao]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcao = $this->funcao->find($id);
        return view('admin.funcao.edit', ['funcao' => $funcao]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FuncaoFormRequest $request, $id)
    {
        $funcao = $this->funcao->find($id);
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $busca = $this->funcao
                    ->where('nome', '=', $nome)
                    ->where('id', '<>', $id)
                    ->get()->first();
        if($busca != null){
            return redirect()
                    ->route('funcoes.edit', $id)
                    ->withErrors(['erros' => 'Função já cadastrada com esse Nome!'])
                    ->withInput();
        }
        //Vai alterar
        $update = $funcao->update($dataForm);
        if($update)
        {
            return redirect()
                    ->route('funcoes.index')
                    ->with(['success' => 'Registro Alterado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/funcoes/Edit', $id)
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
        $funcao = $this->funcao->find($id);
        $busca = $this->empregado
                    ->where('funcao_id', '=', $id)
                    ->get()->count();

        if($busca > 0)
        {
            $message = 'Falha no Delete! Existem '. $busca . ' empregados ligados a esta Função!';
            return redirect()
                ->route('funcoes.show', $id)
                ->withErrors(['errors' => $message])
                ->withInput();
        }

        $busca = $this->grupofuncao
        ->Where('funcao_id', '=', $id)
        ->get()->count();

        if ($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' GrupoFunção ligados a esta Função !';
            return redirect()
                 ->route('funcoes.show', $id)
                 ->withErrors(['errors' => $message])
                 ->withInput();
        }

        $delete = $funcao->delete();
        if($delete)
        {
            return redirect()
                    ->route('funcoes.index')
                    ->with(['success' => 'Registro excluido com Sucesso'])
                    ->withInput();
        }else{
            return redirect()
                    ->route('funcoes.show', $id)
                    ->withErrors(['errors' => 'Erro no Delete'])
                    ->withInput();
        }

    }

    public function search(FuncaoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $funcoes = $this->funcao->where('nome', 'LIKE', $nome)
                    ->orderBy('nome', 'ASC')
                    ->paginate(5);

        return view('admin.funcao.index', ['funcoes' => $funcoes, 'dataForm' => $dataForm]);

    }
}
