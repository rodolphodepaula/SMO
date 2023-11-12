<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empregado;
use App\Models\Atendimento;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Pega o total de empregados
        $total_empregados = Empregado::count();

        // Pega o Total de Atendimentos
        $total_atendimentos = Atendimento::count();

        $ano_atual = date('Y');
        $ano_anterior = date('Y') - 1;
        $cores = ['#b0120a', '#cc9933', '#0066cc', '#009933', '#8ab4f8','#64773e'];

        // Pega os tipos de atendimentos agrupando por Nome do Tipo Atendimento
        $sql = "Select tipoatendimento.nome, sum(atendimento.id + 10) as qtd, '#b0120a' as cor ";
        $sql = $sql . " from atendimento ";
        $sql = $sql . " right join tipoatendimento on atendimento.tipoatendimento_id = tipoatendimento.id  ";
        $sql = $sql . " and year(atendimento.data_atendimento) = '$ano_anterior'  ";
        $sql = $sql . " group by tipoatendimento.nome ";
        $tipoatendimentos1 = DB::select($sql);

        // Pega os tipos de atendimentos agrupando por Nome do Tipo Atendimento
        $sql = "Select tipoatendimento.nome, sum(atendimento.id + 10) as qtd,  '#009933' as cor ";
        $sql = $sql . " from atendimento ";
        $sql = $sql . " right join tipoatendimento on atendimento.tipoatendimento_id = tipoatendimento.id  ";
        $sql = $sql . " and year(atendimento.data_atendimento) = '$ano_atual'  ";
        $sql = $sql . " group by tipoatendimento.nome ";
        $tipoatendimentos2 = DB::select($sql);
        $i = 0;
        for ($i=0; $i < 4; $i++) {
          /*  dd($tipoatendimentos2[$i]);
            $tipoatendimentos1[$i]->cor = $cores[$i];
            $tipoatendimentos2[$i]->cor = $cores[$i];*/

        }

        return view('admin.home', [
            'total_empregados' => $total_empregados,
            'total_atendimentos' => $total_atendimentos,
            'tipoatendimentos1' => $tipoatendimentos1,
            'tipoatendimentos2' => $tipoatendimentos2,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teste()
    {
        // Pega o total de empregados
        $total_empregados = Empregado::count();

        // Pega o Total de Atendimentos
        $total_atendimentos = Atendimento::count();

        $ano_atual = date('Y');
        $ano_anterior = date('Y') - 1;

        // Pega os tipos de atendimentos agrupando por Nome do Tipo Atendimento
        $sql = "Select tipoatendimento.nome, count(atendimento.id) as qtd, '#b0120a' as cor ";
        $sql = $sql . " from atendimento ";
        $sql = $sql . " right join tipoatendimento on atendimento.tipoatendimento_id = tipoatendimento.id  ";
        $sql = $sql . " and YEAR(atendimento.data_atendimento) = '$ano_anterior'  ";
        $sql = $sql . " group by tipoatendimento.nome ";
        $tipoatendimentos1 = DB::select($sql);

        // Pega os tipos de atendimentos agrupando por Nome do Tipo Atendimento
        $sql = "Select tipoatendimento.nome, count(atendimento.id) as qtd, '#009933' as cor ";
        $sql = $sql . " from atendimento ";
        $sql = $sql . " right join tipoatendimento on atendimento.tipoatendimento_id = tipoatendimento.id  ";
        $sql = $sql . " and YEAR(atendimento.data_atendimento) = '$ano_atual'  ";
        $sql = $sql . " group by tipoatendimento.nome ";
        $tipoatendimentos2 = DB::select($sql);

        $cores = ['#b0120a', '#cc9933', '#0066cc', '#009933', '#8ab4f8','#64773e'];

        $i = 0;

        for ($i=0; $i < 4; $i++) {
            if(!empty($tipoatendimentos1)){
                $tipoatendimentos1[$i]->cor = $cores[$i];
            }
            if(!empty($tipoatendimentos2)){
                $tipoatendimentos2[$i]->cor = $cores[$i];
            }

        }
        //dd($tipoatendimentos1);


        return view('admin.home', [
            'total_empregados' => $total_empregados,
            'total_atendimentos' => $total_atendimentos,
            'tipoatendimentos1' => $tipoatendimentos1,
            'tipoatendimentos2' => $tipoatendimentos2,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
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
        //
    }
}