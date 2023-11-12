@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Usuários</h2> 
    </div>

    <div class="form-search" style="margin-bottom:20px; ">
        <form class="form form-inline" method="get" action="{{ route('usuarios.search') }}">   
            <input class="form-control" type="text" name="nome" placeholder="Nome do Usuário"> 
            <button class="btn btn-primary">
            <i class="glyphicon glyphicon-search" aria-hidden="true"></i>
            </button>
        </form>
    </div>
    <div class="form-central" style="margin-top: 0px;">  
        <div class="btn btn-primary" style="margin-bottom: 10px;">
            <a href="{{ route('usuarios.create') }}" style="color: #FFF;">   
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
            <th>E-Mail</th>
            <th>Status</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($usuarios as $user) 
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            @if ($user->status == 1)
                <td>ATIVO</td>
            @else
                <td>INATIVO</td>
            @endif
            <td width="100">  
                <a href="{{route('usuarios.edit', $user->id)}}" class="btn btn-primary btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>

            </td>

        </tr>

        @endforeach

    </table>

    @if( isset($dataForm) )

        {!! $usuarios->appends($dataForm)->links() !!}

    @else

        {!! $usuarios->links() !!}

    @endif

    
</div> 
@endsection