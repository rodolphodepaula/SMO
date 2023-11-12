<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\GrupoRisco;
use App\Models\Risco;
use App\Http\Requests\Admin\GrupoRiscoFormRequest;

class GrupoRiscoController extends Controller
{

    private $grupo;
    private $gruporisco;
    private $risco;

    public function __construct(Grupo $grupo, GrupoRisco $gruporisco, Risco $risco)
    {
        $this->grupo = $grupo;
        $this->gruporisco = $gruporisco;
        $this->risco = $risco;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $grupo = $this->grupo->find($id);
        $riscos = $this->risco
                ->orderBy('nome', 'ASC')->get();


        $gruporiscos = $this->gruporisco
                ->Where('grupo_id', '=', $id)
                ->get();

        return view('admin.gruporisco.index', [
            'grupo' => $grupo,
            'riscos' => $riscos,
            'gruporiscos' => $gruporiscos
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
    public function store(GrupoRiscoFormRequest $request, $id)
    {
        // Pega todos os dados do formulario
        $dataForm = $request->all();

        $grupo = $this->grupo->find($id);

        $risco_id = $dataForm['risco_id'];

        $gruporisco = $this->gruporisco
            ->Where('grupo_id', '=', $id)
            ->Where('risco_id', '=', $risco_id)
            ->get()->first();

        if ($gruporisco != null){
            return redirect()
                    ->route('gruporisco.index', $id)
                    ->withErrors(['errors' => 'Registro já cadastrado!'])
                    ->withInput();
        }

        $insert = $this->gruporisco->insert([
            'grupo_id' => $id,
            'risco_id' => $risco_id
        ]);
        if ( $insert )
            return redirect()
                 ->route('gruporisco.index', $id);
        else
            return redirect()
                 ->route('gruporisco.index', $id)
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoRiscoFormRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gruporisco = $this->gruporisco->find($id);
        $grupo_id = $gruporisco->grupo_id;
        $delete = $gruporisco->delete();
        if ($delete)
            return redirect()
                 ->route('gruporisco.index', $grupo_id)
                 ->withInput();
        else
            return redirect()
                 ->route('gruporisco.index', $grupo_id)
                 ->withErrors(['errors' => 'Erro no Delete'])
                 ->withInput();
    }

}
