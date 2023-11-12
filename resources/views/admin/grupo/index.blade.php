@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Grupos Homogêneos</h2>
    </div>

    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px;">
            <a href="{{ route('grupos.create') }}" style="color: #FFF;">
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
            <th>Grupo Homogêneo</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($grupos as $grupo)
        <tr>
            <td>{{$grupo->nome}}</td>
            <td width="100">
                <a href="{{route('grupos.edit', $grupo->id)}}" class="btn btn-primary btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>

                <a href="{{route('grupos.show', $grupo->id)}}" class="btn btn-danger btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>

            </td>

        </tr>

        @endforeach

    </table>



</div>
@endsection
