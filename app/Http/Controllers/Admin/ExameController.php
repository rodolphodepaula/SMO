<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exame;
use App\Models\AtendimentoExame;
use App\Models\GrupoExame;
use App\Http\Requests\Admin\ExameFormRequest;


class ExameController extends Controller
{
    private $exame;
    private $grupoexame;
    private $atendimentoexame;

    public function __construct(Exame $exame, GrupoExame $grupoexame, AtendimentoExame $atendimentoexame)
    {

        $this->exame = $exame;
        $this->grupoexame = $grupoexame;
        $this->atendimentoexame = $atendimentoexame;


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exames = $this->exame
                    ->orderBy('nome', 'ASC')
                    ->paginate(5);

        return view('admin.exame.index', ['exames' => $exames]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.exame.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExameFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $exame = $this->exame
                    ->where('nome', '=', $nome)
                    ->get()->first();
        if($exame != null){
            return redirect()
                    ->route('exames.create')
                    ->withErrors(['erros' => 'Exame já cadastrada com esse Nome!'])
                    ->withInput();
        }
        //Vai inserir
        $insert = $this->exame->insert([
                'nome' => $dataForm['nome']
        ]);

        if($insert)
        {
            return redirect()
                    ->route('exames.index')
                    ->with(['success' => 'Registro Cadastrado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/exames/create')
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
        $exame = $this->exame->find($id);
        return view('admin.exame.show', ['exame' => $exame]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exame = $this->exame->find($id);
        return view('admin.exame.edit', ['exame' => $exame]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExameFormRequest $request, $id)
    {
        $exame = $this->exame->find($id);
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $busca = $this->exame
                    ->where('nome', '=', $nome)
                    ->where('id', '<>', $id)
                    ->get()->first();
        if($busca != null){
            return redirect()
                    ->route('exames.edit', $id)
                    ->withErrors(['erros' => 'Exame já cadastrado com esse Nome!'])
                    ->withInput();
        }
        //Vai alterar
        $update = $exame->update($dataForm);
        if($update)
        {
            return redirect()
                    ->route('exames.index')
                    ->with(['success' => 'Registro Alterado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/exames/Edit', $id)
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
        $exame = $this->exame->find($id);
        $busca = $this->grupoexame
                    ->where('exame_id', '=', $id)
                    ->get()->count();

        if($busca > 0)
        {
            $message = 'Falha no Delete! Existem '. $busca . ' GruposExames ligados a este Exame!';
            return redirect()
                ->route('exames.show', $id)
                ->withErrors(['errors' => $message])
                ->withInput();
        }

        $busca = $this->atendimentoexame
        ->Where('exame_id', '=', $id)
        ->get()->count();

        if ($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' AtendimentoExame ligados a este Exame !';
            return redirect()
                 ->route('exames.show', $id)
                 ->withErrors(['errors' => $message])
                 ->withInput();
        }

        $delete = $exame->delete();
        if($delete)
        {
            return redirect()
                    ->route('exames.index')
                    ->with(['success' => 'Registro excluido com Sucesso'])
                    ->withInput();
        }else{
            return redirect()
                    ->route('exames.show', $id)
                    ->withErrors(['errors' => 'Erro no Delete'])
                    ->withInput();
        }
    }

    public function search(ExameFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $exames = $this->exame->where('nome', 'LIKE', $nome)
                    ->orderBy('nome', 'ASC')
                    ->paginate(5);

        return view('admin.exame.index', ['exames' => $exames, 'dataForm' => $dataForm]);

    }
}
