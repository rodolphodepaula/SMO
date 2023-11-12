<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grupo;
use App\Models\Setor;
use App\Models\Funcao;
use App\Models\Empregado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmpregadoFormRequest;

class EmpregadoController extends Controller
{

    private $empregado;

    public function __construct(Empregado $empregado, Setor $setor, Funcao $funcao, Grupo $grupo)
    {
        $this->empregado = $empregado;
        $this->setor = $setor;
        $this->funcao = $funcao;
        $this->grupo = $grupo;


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empregados = $this->empregado
                        ->orderBy('nome', 'ASC')
                        ->paginate(8);
        return view('admin.empregado.index',['empregados' => $empregados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $setores = $this->setor
                    ->orderBy('nome', 'ASC')
                    ->get();
        $funcoes = $this->funcao
                    ->orderBy('nome', 'ASC')
                    ->where('id', '=', 0)
                    ->get();
        $grupos = $this->grupo
                    ->orderBy('nome', 'ASC')
                    ->where('id', '=', 0)
                    ->get();

        return view('admin.empregado.create', ['setores' => $setores, 'funcoes' => $funcoes, 'grupos' => $grupos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpregadoFormRequest $request)
    {

        $dataForm = $request->all();
        $busca = $this->empregado
                    ->where('nome', '=', $dataForm['nome'])
                    ->where('cpf', '=', $dataForm['cpf'])
                    ->where('data_demissao', '=', null)
                    ->get()->first();
        if($busca != null ){
            return redirect()
                    ->route('empregado.create')
                    ->withErrors(['errors' => 'Já existeno cadastro este Nome e CPF!'])
                    ->withInput();
        }
        $insert = $this->empregado->insert([
            'nome' => $dataForm['nome'],
            'cpf' => $dataForm['cpf'],
            'ctps' => $dataForm['ctps'],
            'serie' => $dataForm['serie'],
            'data_nascimento' => $dataForm['data_nascimento'],
            'data_admissao' => $dataForm['data_admissao'],
            'data_demissao' => $dataForm['data_demissao'],
            'setor_id' => $dataForm['setor_id'],
            'funcao_id' => $dataForm['funcao_id'],
            'grupo_id' => $dataForm['grupo_id'],
        ]);

        if($insert)
            return redirect()
            ->route('empregados.index')
            ->with(['success' => 'Registro cadastrado com sucesso!'])
            ->withInput();
        else
            return redirect()
            ->route('empregados.create')
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
        $empregado = $this->empregado->find($id);
        $funcao_id = $empregado->funcao_id;
        $setor_id = $empregado->setor_id;
        $grupo_id = $empregado->grupo_id;

        $setores = $this->setor
                    ->orderBy('nome', 'ASC')->get();
        $funcoes = $this->funcao
                    ->where('id', '=', $funcao_id)
                    ->orderBy('nome', 'ASC')->get();

        $grupos = $this->grupo
                ->where('id', '=', $grupo_id)
                ->orderBy('nome', 'ASC')->get();

        return view('admin.empregado.edit', [
                'empregado' => $empregado,
                'setores' => $setores,
                'funcoes' => $funcoes,
                'grupos' => $grupos
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmpregadoFormRequest $request, $id)
    {
        $empregado = $this->empregado->find($id);
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        $cpf = $dataForm['cpf'];
        $busca = $this->empregado
                    ->where('nome', '=', $nome)
                    ->where('cpf', '=', $cpf)
                    ->where('id', '<>', $id)
                    ->where('data_demissao', '=', null)
                    ->get()->first();
        if($busca != null){
            return redirect()
                    ->route('empregados.create')
                    ->withErrors(['errors' => 'Já existe no cadastro este Nome e CPF'])
                    ->withInput();
        }

        $update = $empregado->update($dataForm);
        if($update)
            return redirect()
                    ->route('empregados.index')
                    ->with(['success' => 'Registro alterado com Sucesso'])
                    ->withInput();
        else
            return redirect()
                    ->route('empregados.edit', $id)
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

    }

    public function search()
    {

    }

        /**
         * Método Ajax
         */

    public function loadFuncoes(Request $request)
    {
       $dataForm = $request->all();
       $setor_id = $dataForm['setor_id'];
       $sql = 'Select distinct funcao.id, funcao.nome from grupofuncao, funcao ';
       $sql = $sql . 'Where grupofuncao.funcao_id = funcao.id ';
       $sql = $sql . 'and grupofuncao.setor_id = '.$setor_id.' ';
       $sql = $sql . 'order by funcao.nome ';
       $funcoes = DB::select($sql);

       return view('admin.empregado.funcao_ajax', ['funcoes' => $funcoes]);


    }
        /**
         * Método Ajax
         */

    public function loadGrupos(Request $request)
    {
        $dataForm = $request->all();
       $setor_id = $dataForm['setor_id'];
       $funcao_id= $dataForm['funcao_id'];
       $sql = 'Select distinct grupo.id, grupo.nome from grupofuncao, funcao, grupo ';
       $sql = $sql . 'Where grupofuncao.funcao_id = funcao.id ';
       $sql = $sql . 'and grupofuncao.grupo_id = grupo.id ';
       $sql = $sql . 'and grupofuncao.setor_id = '.$setor_id.' ';
       $sql = $sql . 'and grupofuncao.funcao_id = '.$funcao_id.' ';
       $sql = $sql . 'order by grupo.nome ';
       $grupos = DB::select($sql);

       return view('admin.empregado.grupo_ajax', ['grupos' => $grupos]);

    }
}
