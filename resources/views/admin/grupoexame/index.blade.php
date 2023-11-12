@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Grupos Homogêneos - Grupo Exame</h2>
    </div>

    <form class="form-horizontal" method="POST" action="{{ route('grupoexame.store', $grupo->id) }}">
        <div class="aba">
            <ul class="nav nav-tabs" style="margin-bottom: 10px; margin-top: -10px;">
                <li><a href="{{route('grupos.edit', $grupo->id)}}">Grupo</a></li>
                <li><a href="{{route('grupofuncao.index', $grupo->id)}}" style="cursor: pointer;">Funções X Setores</a></li>
                <li><a href="{{route('gruporisco.index', $grupo->id)}}" style="cursor: pointer;">Riscos</a></li>
                <li class="active"><a href="{{route('grupoexame.index', $grupo->id)}}" style="cursor: pointer;">Exames</a></li>
            </ul>
        </div>
        <div class="form1">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="nome">Grupo:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="nome" value="{{ $grupo->nome }}">
              </div>
            </div>

        </div>

        <div class="form2">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="exame_id">Exame:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="exame_id">
                        <option value="">Selecione</option>
                        @foreach($exames as $exame)
                            <option value="{{$exame->id}}">{{$exame->nome}}</option>
                        @endforeach
                    </select>
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="tipoatendimento_id">Tipo Atendimento:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="tipoatendimento_id">
                        <option value="">Selecione</option>
                        @foreach($tipoatendimentos as $tipoatendimento)
                            <option value="{{$tipoatendimento->id}}">{{$tipoatendimento->nome}}</option>
                        @endforeach
                    </select>
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
    <br>
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>Exame</th>
            <th>Tipo de Atendimento</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($grupoexames as $grupoexame)
        <tr>
            <td>{{ $grupoexame->exame['nome'] }}</td>
            <td>{{ $grupoexame->tipoatendimento['nome'] }}</td>
            <td width="100">
                <a href="{{route('grupoexame.destroy', $grupoexame->id)}}" class="btn btn-danger btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>

            </td>

        </tr>

        @endforeach

    </table>

</div>
@endsection
