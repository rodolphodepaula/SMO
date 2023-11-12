@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Tipos de Usuários</h2>
    </div>
    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('tipousuarios.index') }}" style="color: #FFF;">
            <i style="font-size: 20px;" class="glyphicon glyphicon-backward" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <form class="form-horizontal" method="post" action="{{ route('tipousuarios.update', $tipousuario->id) }}">
        <div class="aba">
            <ul class="nav nav-tabs" style="margin-bottom: 10px; margin-top: -10px;">
                <li class="active"><a href="{{route('tipousuarios.edit', $tipousuario->id)}}">Tipo Usuário</a></li>
                <li><a href="{{route('permissoes.index', $tipousuario->id)}}" style="cursor: pointer;">Permissões</a></li>
            </ul>
        </div>
        <div class="form1">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="nome">Tipo Usário:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="nome" value="{{ $tipousuario->nome }}">
              </div>
            </div>

            <div class="form-central" style="margin-top: 35px;">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">
                    <i style="font-size: 20px;" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Salvar
                  </button>
                </div>
            </div>
        </div>

    </form>
    @if ( isset($errors) && count($errors) > 0)
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
    @endif
</div>
@endsection
