<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Admin\TipoUsuarioFormRequest;
use App\Models\TipoUsuario;
use App\Models\User;

class TipoUsuarioController extends Controller
{


    private $tipousuario;
    private $users;

    public function __construct(TipoUsuario $tipousuario, User $users)
    {
        $this->tipousuario = $tipousuario;
        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipousuarios = $this->tipousuario
                    ->orderBy('nome', 'ASC')->get();
        return view('admin.tipousuario.index', ['tipousuarios' => $tipousuarios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tipousuario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoUsuarioFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $tipousuario = $this->tipousuario
                    ->where('nome', '=', $nome)
                    ->get()->first();
        if($tipousuario != null){
            return redirect()
                    ->route('tipousuarios.create')
                    ->withErrors(['erros' => 'Tipo de Usuário já cadastrada com esse Nome!'])
                    ->withInput();
        }
        //Vai inserir
        $insert = $this->tipousuario->insert([
                'nome' => $dataForm['nome']
        ]);

        if($insert)
        {
            return redirect()
                    ->route('tipousuarios.index')
                    ->with(['success' => 'Registro Cadastrado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/tipousuarios/create')
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
        $tipousuario = $this->tipousuario->find($id);
        return view('admin.tipousuario.show', ['tipousuario' => $tipousuario]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipousuario = $this->tipousuario->find($id);
        return view('admin.tipousuario.edit', ['tipousuario' => $tipousuario]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoUsuarioFormRequest $request, $id)
    {
        $tipousuario = $this->tipousuario->find($id);
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        //Verifica se o nome já está cadastrado
        $busca = $this->tipousuario
                    ->where('nome', '=', $nome)
                    ->where('id', '<>', $id)
                    ->get()->first();
        if($busca != null){
            return redirect()
                    ->route('tipousuarios.edit', $id)
                    ->withErrors(['erros' => 'Tipo Usuário já cadastrado com esse Nome!'])
                    ->withInput();
        }
        //Vai alterar
        $update = $tipousuario->update($dataForm);
        if($update)
        {
            return redirect()
                    ->route('tipousuarios.index')
                    ->with(['success' => 'Registro Alterado com Sucesso'])
                    ->withInput();
        }else{
            return redirect('admin/tipousuarios/edit', $id)
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
        $tipousuario = $this->tipousuario->find($id);

        //Verifica se existe Usuarios
        $busca = $this->users
                    ->where('tipousuario_id', '=', $id)
                    ->get()->count();

        if($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' Usuários ligados a este Tipo!';
            return redirect()
                    ->route('tipousuarios.show', $id)
                    ->withErrors(['errors' => $message])
                    ->withInput();
        }

        $delete = $tipousuario->delete();
        if($delete)
        {
            return redirect()
                    ->route('tipousuarios.index')
                    ->with(['success' => 'Registro excluido com Sucesso'])
                    ->withInput();
        }else{
            return redirect()
                    ->route('tipousuarios.show', $id)
                    ->withErrors(['errors' => 'Erro no Delete'])
                    ->withInput();
        }


    }
}
