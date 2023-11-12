@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Tipos de Usuários</h2>
    </div>

    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px;">
            <a href="{{ route('tipousuarios.create') }}" style="color: #FFF;">
            <i style="font-size: 20px;" class="glyphicon glyphicon-plus" aria-hidden="true"></i> Cadastrar
            </a>
        </div>
    </div>
    @if(Session::has('success'))
        <div class="alert alert-success hide-msg" style="float:left; width:100%; margin:10px 0px;">
        {{Session::get('success')}}
        </div>
    @endif
    <br>
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>Tipos de Usuários</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($tipousuarios as $tipousuario)
        <tr>
            <td>{{$tipousuario->nome}}</td>
            <td width="100">
                <a href="{{route('tipousuarios.edit', $tipousuario->id)}}" class="btn btn-primary btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>

                <a href="{{route('tipousuarios.show', $tipousuario->id)}}" class="btn btn-danger btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>

            </td>

        </tr>

        @endforeach

    </table>

</div>
@endsection
