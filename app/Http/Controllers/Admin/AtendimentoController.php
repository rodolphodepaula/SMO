<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atendimento;
use App\Models\Empregado;
use App\Models\TipoAtendimento;
use App\Models\Coordenador;
use App\Models\AtendimentoExame;
use App\Models\AtendimentoRisco;
use App\Models\GrupoExame;
use App\Models\GrupoRisco;
use App\Http\Requests\Admin\AtendimentoFormRequest;
use Illuminate\Support\Facades\DB;

class AtendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $atendimento;
    public function __construct(Atendimento $atendimento, Empregado $empregado
                , TipoAtendimento $tipoatendimento,  Coordenador $coordenador
                , AtendimentoExame $atendimentoexame, AtendimentoRisco $atendimentorisco
                , GrupoExame $grupoexame, GrupoRisco $gruporisco)
    {
        $this->atendimento = $atendimento;
        $this->empregado = $empregado;
        $this->tipoatendimento = $tipoatendimento;
        $this->coordenador = $coordenador;
        $this->atendimentoexame = $atendimentoexame;
        $this->atendimentorisco = $atendimentorisco;
        $this->grupoexame = $grupoexame;
        $this->gruporisco = $gruporisco;
    }

    public function index()
    {
        $atendimentos = DB::table('atendimento')
                ->join('empregado', 'empregado.id', '=', 'atendimento.empregado_id')
                ->join('tipoatendimento', 'tipoatendimento.id', '=', 'atendimento.tipoatendimento_id')
                ->select('atendimento.id', 'empregado.nome', 'atendimento.data_atendimento', 'tipoatendimento.nome as tipo')
                ->orderBy('atendimento.data_atendimento', 'DESC')
                ->paginate(5);
        return view('admin.atendimento.index', ['atendimentos' =>$atendimentos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empregados = $this->empregado
                    ->orderBy('nome', 'ASC')
                    ->get();
        $tipoatendimentos = $this->tipoatendimento
                    ->orderBy('nome', 'ASC')
                    ->get();
        return view('admin.atendimento.create', [
            'empregados' => $empregados,
            'tipoatendimentos' => $tipoatendimentos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AtendimentoFormRequest $request)
    {
        $dataForm = $request->except('_token');
        $busca = $this->atendimento
                ->Where('empregado_id', '=', $dataForm['empregado_id'])
                ->Where('tipoatendimento_id', '=', $dataForm['tipoatendimento_id'])
                ->Where('data_atendimento', '=', $dataForm['data_atendimento'])
                ->get()->first();
        if ($busca != null){
            return redirect()
                    ->route('atendimentos.create')
                    ->withErrors(['errors' => 'Atendimento já cadastrado !'])
                    ->withInput();
        }
        if (isset($dataForm['trabalhoaltura'])){
            $dataForm['trabalhoaltura'] = 1;
        }else{
            $dataForm['trabalhoaltura'] = 0;
        }
        if (isset($dataForm['espacoconfinado'])){
            $dataForm['espacoconfinado'] = 1;
        }else{
            $dataForm['espacoconfinado'] = 0;
        }
        if (isset($dataForm['apto'])){
            $dataForm['apto'] = 1;
        }else{
            $dataForm['apto'] = 0;
        }

        $coord = $this->coordenador
                ->Where('data_fim', '=', null)
                ->get()->first();
        $dataForm['coordenador_id'] = $coord->id;

        $empregado_id = $dataForm['empregado_id'];
        $empregado = $this->empregado->find($empregado_id);
        $dataForm['setor_id'] = $empregado->setor_id;
        $dataForm['funcao_id'] = $empregado->funcao_id;
        $dataForm['grupo_id']= $empregado->grupo_id;

        $atendimento = new Atendimento();
        $atendimento->data_atendimento = $dataForm['data_atendimento'];
        $atendimento->empregado_id = $dataForm['empregado_id'];
        $atendimento->tipoatendimento_id = $dataForm['tipoatendimento_id'];
        $atendimento->setor_id = $dataForm['setor_id'];
        $atendimento->funcao_id = $dataForm['funcao_id'];
        $atendimento->grupo_id = $dataForm['grupo_id'];
        $atendimento->coordenador_id = $dataForm['coordenador_id'];
        $atendimento->trabalhoaltura = $dataForm['trabalhoaltura'];
        $atendimento->espacoconfinado = $dataForm['espacoconfinado'];
        $atendimento->apto = $dataForm['apto'];
        $insert = $atendimento->save();
        if ( $insert ){
            $atendimento_id = $atendimento->id;

            // Vai buscar os riscos em gruporisco
            $gruporiscos = $this->gruporisco
                    ->Where('grupo_id', '=', $dataForm['grupo_id'])
                    ->get();
            foreach ($gruporiscos as $gruporisco){
                $atendimentorisco = new AtendimentoRisco();
                $atendimentorisco->atendimento_id = $atendimento_id;
                $atendimentorisco->risco_id = $gruporisco->risco_id;
                $insert = $atendimentorisco->save();
                if ( $insert == false){
                    return redirect()
                        ->route('atendimentos.create')
                        ->withErrors(['errors' => 'Erro no Insert Atendimento Risco'])
                        ->withInput();
                }
            }

            // Vai buscar os exames em grupoexame
            $grupoexames = $this->grupoexame
                    ->Where('grupo_id', '=', $dataForm['grupo_id'])
                    ->Where('tipoatendimento_id', '=', $dataForm['tipoatendimento_id'])
                    ->get();
            foreach ($grupoexames as $grupoexame){
                $atendimentoexame = new AtendimentoExame();
                $atendimentoexame->atendimento_id = $atendimento_id;
                $atendimentoexame->exame_id = $grupoexame->exame_id;
                $insert = $atendimentoexame->save();
                if ( $insert == false){
                    return redirect()
                        ->route('atendimentos.create')
                        ->withErrors(['errors' => 'Erro no Insert Atendimento Exame'])
                        ->withInput();
                }
            }
            return redirect()
                    ->route('atendimentos.index')
                    ->with(['success' => 'Registro incluido com Sucesso'])
                    ->withInput();

        }else{
            return redirect()
                 ->route('atendimentos.create')
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
        $atendimento = $this->atendimento->find($id);
        $empregado_id = $atendimento->empregado_id;
        $empregados = $this->empregado
                    ->Where('id', '=', $empregado_id)
                    ->get();
        $tipoatendimentos = $this->tipoatendimento
            ->orderBy('nome', 'ASC')
            ->get();

        return view('admin.atendimento.show', [
            'empregados' => $empregados,
            'tipoatendimentos' => $tipoatendimentos,
            'atendimento' => $atendimento
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $atendimento = $this->atendimento->find($id);
        $empregado_id = $atendimento->empregado_id;
        $empregados = $this->empregado
                    ->Where('id', '=', $empregado_id)
                    ->get();
        $tipoatendimentos = $this->tipoatendimento
            ->orderBy('nome', 'ASC')
            ->get();

        return view('admin.atendimento.edit', [
            'empregados' => $empregados,
            'tipoatendimentos' => $tipoatendimentos,
            'atendimento' => $atendimento
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AtendimentoFormRequest $request, $id)
    {
        $atendimento = $this->atendimento->find($id);
        $grupo_id = $atendimento->grupo_id;
        $dataForm = $request->except('_token');
        $tipoatendimento_id_anterior = $atendimento->tipoatendimento_id;
        if (isset($dataForm['trabalhoaltura'])){
            $dataForm['trabalhoaltura'] = 1;
        }else{
            $dataForm['trabalhoaltura'] = 0;
        }
        if (isset($dataForm['espacoconfinado'])){
            $dataForm['espacoconfinado'] = 1;
        }else{
            $dataForm['espacoconfinado'] = 0;
        }
        if (isset($dataForm['apto'])){
            $dataForm['apto'] = 1;
        }else{
            $dataForm['apto'] = 0;
        }
        $atendimento->data_atendimento = $dataForm['data_atendimento'];
        $atendimento->tipoatendimento_id = $dataForm['tipoatendimento_id'];
        $atendimento->trabalhoaltura = $dataForm['trabalhoaltura'];
        $atendimento->espacoconfinado = $dataForm['espacoconfinado'];
        $atendimento->apto = $dataForm['apto'];
        $update = $atendimento->save();

        // Verifica se o tipoatendimento é diferente do anterior
        if ($tipoatendimento_id_anterior == $dataForm['tipoatendimento_id']){
            return redirect()
                    ->route('atendimentos.edit', $id)
                    ->with(['success' => 'Registro alterado com Sucesso'])
                    ->withInput();
        }else{
            // Vai deletar todos os atendimento exame ligados ao atendimento
            $sql = "delete from atendimentoexame  ";
            $sql = $sql . " where atendimento_id = '$id'  ";
            $del = DB::select($sql);

            // Vai buscar os exames em grupoexame
            $grupoexames = $this->grupoexame
                    ->Where('grupo_id', '=', $grupo_id)
                    ->Where('tipoatendimento_id', '=', $dataForm['tipoatendimento_id'])
                    ->get();
            foreach ($grupoexames as $grupoexame){
                $atendimentoexame = new AtendimentoExame();
                $atendimentoexame->atendimento_id = $id;
                $atendimentoexame->exame_id = $grupoexame->exame_id;
                $insert = $atendimentoexame->save();
                if ( $insert == false){
                    return redirect()
                        ->route('atendimentos.edit', $id)
                        ->withErrors(['errors' => 'Erro no Insert Atendimento Exame'])
                        ->withInput();
                }
            }
            return redirect()
                    ->route('atendimentos.edit', $id)
                    ->with(['success' => 'Registro alterado com Sucesso'])
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
        $atendimento = $this->atendimento->find($id);

        // Deletar todos os Riscos desste Atendimento
        $sql = "delete from atendimentorisco  ";
        $sql = $sql . " where atendimento_id = '$id'  ";
        $del = DB::select($sql);

        // Deletar todos os Exames deste Atendimento
        $sql = "delete from atendimentoexame  ";
        $sql = $sql . " where atendimento_id = '$id'  ";
        $del = DB::select($sql);

        // Deletar o Atendimento
        $delete = $atendimento->delete();
        if ($delete)
            return redirect()
                    ->route('atendimentos.index')
                    ->with(['success' => 'Registro excluido com Sucesso'])
                    ->withInput();
        else
            return redirect()
                ->route('atendimentos.show', $id)
                ->withErrors(['errors' => 'Erro no Delete Atendimento '])
                ->withInput();
    }

    public function search(Request $request)
    {
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $atendimentos = DB::table('atendimento')
                ->where('empregado.nome', 'LIKE', $nome)
                ->join('empregado', 'empregado.id', '=', 'atendimento.empregado_id')
                ->join('tipoatendimento', 'tipoatendimento.id', '=', 'atendimento.tipoatendimento_id')
                ->select('atendimento.id', 'empregado.nome', 'atendimento.data_atendimento', 'tipoatendimento.nome as tipo')
                ->orderBy('atendimento.data_atendimento', 'DESC')
                ->get();
        return view('admin.atendimento.index', ['atendimentos' =>$atendimentos, 'dataForm' =>$dataForm]);
    }

    public function rel_aso($id)
    {
        $atendimento = $this->atendimento->find($id);

        // Pega todos os exames em atendimentoexame
        $atendimentoexames = $this->atendimentoexame
                    ->Where('atendimento_id', '=', $id)
                    ->get();

        // Pega todos os riscos em atendimentorisco
        $atendimentoriscos = $this->atendimentorisco
                    ->Where('atendimento_id', '=', $id)
                    ->get();

        return view('admin.atendimento.rel_aso', [
            'atendimento' => $atendimento,
            'atendimentoexames' => $atendimentoexames,
            'atendimentoriscos' => $atendimentoriscos
        ]);
    }
}