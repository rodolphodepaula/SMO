@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Atendimentos</h2>  
    </div>

    <div class="form-search" style="margin-bottom:20px; ">
        <form class="form form-inline" method="get" action="{{ route('atendimentos.search') }}">   
            <input class="form-control" type="text" name="nome" placeholder="Nome do Empregado"> 
            <button class="btn btn-primary">
            <i class="glyphicon glyphicon-search" aria-hidden="true"></i>
            </button>
        </form>
    </div>
    <div class="form-central" style="margin-top: 0px;">  
        <div class="btn btn-primary" style="margin-bottom: 10px;">
            <a href="{{ route('atendimentos.create') }}" style="color: #FFF;">   
            <i style="font-size: 20px;" class="glyphicon glyphicon-plus" aria-hidden="true"></i> Cadastrar
            </a>
        </div>    
    </div>
    @if(Session::has('success'))
        <div class="alert alert-success hide-msg" style="float:left; width:100%; margin:10px 0px;">
        {{Session::get('success')}}    
        </div>  
    @endif
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>Nome</th>
            <th>Data</th>
            <th>Tipo Atendimento</th>
            <th width="150">Ações</th>
        </tr>
        @foreach($atendimentos as $atendimento) 
        <tr>
            <td>{{ $atendimento->nome }}</td>
            <td>{{ \Carbon\Carbon::parse($atendimento->data_atendimento)->format('d/m/Y') }}</td>
            <td>{{ $atendimento->tipo }}</td>
            <td width="150">  
                <a href="{{route('atendimentos.rel_aso', $atendimento->id)}}" target="_blank" class="btn btn-success btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-print" aria-hidden="true"></i>
                </a>
                <a href="{{route('atendimentos.edit', $atendimento->id)}}" class="btn btn-primary btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>
                <a href="{{route('atendimentos.show', $atendimento->id)}}" class="btn btn-danger btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>
            </td>

        </tr>

        @endforeach

    </table>

    @if( !isset($dataForm) )

        {!! $atendimentos->links() !!}

    @endif

    
</div> 

@endsection