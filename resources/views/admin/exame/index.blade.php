@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Exames</h2>
    </div>

    <div class="form-search" style="margin-bottom:20px; ">
        <form class="form form-inline" method="get" action="{{ route('exames.search') }}">
            <input class="form-control" type="text" name="nome" placeholder="Nome do Exame">
            <button class="btn btn-primary">
            <i class="glyphicon glyphicon-search" aria-hidden="true"></i>
            </button>
        </form>
    </div>
    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px;">
            <a href="{{ route('exames.create') }}" style="color: #FFF;">
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
            <th>Exame</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($exames as $exame)
        <tr>
            <td>{{$exame->nome}}</td>
            <td width="100">
                <a href="{{route('exames.edit', $exame->id)}}" class="btn btn-primary btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>

                <a href="{{route('exames.show', $exame->id)}}" class="btn btn-danger btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>

            </td>

        </tr>

        @endforeach

    </table>

    @if( isset($dataForm) )

        {!! $exames->appends($dataForm)->links() !!}

    @else

        {!! $exames->links() !!}

    @endif


</div>
@endsection
