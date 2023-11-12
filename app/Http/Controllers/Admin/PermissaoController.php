<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permissao;
use App\Models\TipoUsuario;
use App\Models\Formulario;
use App\Http\Requests\Admin\PermissaoFormRequest;

class PermissaoController extends Controller
{

    private $permissao;

    public function __construct(Permissao $permissao, TipoUsuario $tipousuario, Formulario $formulario)
    {
        $this->permissao = $permissao;
        $this->tipousuario = $tipousuario;
        $this->formulario = $formulario;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $tipousuario = $this->tipousuario->find($id);
        $formularios = $this->formulario
                        ->orderBy('nome', 'ASC')->get();

        $permissoes = $this->permissao
                        ->where('tipousuario_id', '=', $id)->get();

        return view('admin.permissao.index', [
            'tipousuario' => $tipousuario,
            'formularios' => $formularios,
            'permissoes' => $permissoes
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
    public function store(PermissaoFormRequest $request, $id)
    {
       $dataForm = $request->all();
       if(isset($dataForm['inclui']))
       {
           $dataForm['inclui'] = 1;
       }else{
            $dataForm['inclui'] = 0;
       }

       if(isset($dataForm['altera']))
       {
           $dataForm['altera'] = 1;
       }else{
            $dataForm['altera'] = 0;
       }

       if(isset($dataForm['exclui']))
       {
           $dataForm['exclui'] = 1;
       }else{
            $dataForm['exclui'] = 0;
       }

       //validação
       $permissao = $this->permissao
                    ->where('tipousuario_id', '=', $id)
                    ->where('formulario_id', '=', $dataForm['formulario_id'])
                    ->get()->first();

        if($permissao != null){
            return redirect()
                    ->route('permissoes.index', $id)
                    ->withErrors(['erros' => 'Registro já cadastrado!'])
                    ->withInput();
        }

       $insert = $this->permissao->insert([
            'tipousuario_id' => $id,
            'formulario_id' => $dataForm['formulario_id'],
            'inclui' => $dataForm['inclui'],
            'altera' => $dataForm['altera'],
            'exclui' => $dataForm['exclui']

       ]);

       if($insert)
       {
           return redirect()
                    ->route('permissoes.index', $id);
       }else{
           return redirect()
                    ->route('permissoes.index', $id)
                    ->withErrors(['errors' => 'Erro no Insert'])
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
        $permissao = $this->permissao->find($id);
        $tipousuario_id = $permissao->tipousuario_id;
        $formulario_id = $permissao->formulario_id;
        $tipousuario = $this->tipousuario->find($tipousuario_id);
        $formularios = $this->formulario
                        ->where('id', '=', $formulario_id)
                        ->orderBy('nome', 'ASC')->get();
        $permissoes = $this->permissao
                        ->where('tipousuario_id', '=', $tipousuario_id)
                        ->get();
        return view('admin.permissao.edit', [
            'permissao' => $permissao,
            'tipousuario' => $tipousuario,
            'formularios' => $formularios,
            'permissoes' => $permissoes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissaoFormRequest $request, $id)
    {
        $permissao = $this->permissao->find($id);
        $dataForm = $request->all();

        if(isset($dataForm['inclui']) == 'on')
        {
            $dataForm['inclui'] = 1;
        }else
        {
            $dataForm['inclui'] = 0;
        }

        if(isset($dataForm['altera']) == 'on')
        {
            $dataForm['altera'] = 1;
        }else
        {
            $dataForm['altera'] = 0;
        }

        if(isset($dataForm['exclui']) == 'on')
        {
            $dataForm['exclui'] = 1;
        }else
        {
            $dataForm['exclui'] = 0;
        }

        $update = $permissao->update($dataForm);

        if($update)
            return redirect()
                    ->route('permissoes.edit', $id)
                    ->with(['success' => 'Registro alterado com sucesso'])
                    ->withInput();
        else
            return redirect()
                    ->route('permissoes.edit', $id)
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
        $permissao = $this->permissao->find($id);
        $tipousuario_id = $permissao->tipousuario_id;
        $delete = $permissao->delete();
        if ($delete)
            return redirect()
                 ->route('permissoes.index', $tipousuario_id)
                 ->withInput();
        else
            return redirect()
                 ->route('permissoes.index', $tipousuario_id)
                 ->withErrors(['errors' => 'Erro no Delete'])
                 ->withInput();
    }

}
