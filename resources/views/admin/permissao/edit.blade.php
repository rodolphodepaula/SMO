@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Tipos de Usuários - Permissões</h2>
    </div>

    <form class="form-horizontal" method="POST" action="{{ route('permissoes.update', $permissao->id) }}">
        <div class="aba">
            <ul class="nav nav-tabs" style="margin-bottom: 10px; margin-top: -10px;">
                <li><a href="{{route('tipousuarios.edit', $tipousuario->id)}}">Tipo Usuário</a></li>
                <li class="active"><a href="{{route('permissoes.index', $tipousuario->id)}}" style="cursor: pointer;">Permissões</a></li>
            </ul>
        </div>
        <div class="form1">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="nome">Tipo Usuário:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="nome" value="{{ $tipousuario->nome }}">
              </div>
            </div>

        </div>

        <div class="form3">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="formulario_id">Formulário:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="formulario_id">
                        <option value="">Selecione</option>
                        @foreach($formularios as $formulario)
                        @if ($formulario->id == $permissao->formulario_id)
                            <option value="{{$formulario->id}}" selected >{{$formulario->nome}}</option>
                        @else
                            <option value="{{$formulario->id}}">{{$formulario->nome}}</option>
                        @endif
                            @endforeach
                    </select>
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="inclui">Permissoes:</label>
                <div class="col-sm-2">
                    @if ($permissao->inclui == 1)
                        <input type="checkbox" name="inclui" checked> Inclui
                    @else
                        <input type="checkbox" name="inclui"> Inclui
                    @endif
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="altera"></label>
                <div class="col-sm-2">
                    @if ($permissao->altera == 1)
                        <input type="checkbox" name="altera" checked> Altera
                    @else
                        <input type="checkbox" name="altera"> Altera
                    @endif
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="exclui"></label>
                <div class="col-sm-2">
                    @if ($permissao->exclui == 1)
                        <input type="checkbox" name="exclui" checked> Exclui
                    @else
                        <input type="checkbox" name="exclui"> Exclui
                    @endif
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
    <br><br><br>
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>Formulário</th>
            <th>INCLUI</th>
            <th>ALTERA</th>
            <th>EXCLUI</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($permissoes as $permissao)
        <tr>
            <td>{{ $permissao->formulario['nome'] }}</td>
            @if($permissao->inclui==1)
                <td>
                    <input type="checkbox" disabled="disabled" checked id="inc">
                </td>
            @else
                <td>
                    <input type="checkbox" disabled="disabled" id="inc">
                </td>
            @endif
            @if($permissao->altera==1)
                <td>
                    <input type="checkbox" disabled="disabled" checked id="alt">
                </td>
            @else
                <td>
                    <input type="checkbox" disabled="disabled" id="alt">
                </td>
            @endif
            @if($permissao->exclui==1)
                <td>
                    <input type="checkbox" disabled="disabled" checked id="exc">
                </td>
            @else
                <td>
                    <input type="checkbox" disabled="disabled" id="exc">
                </td>
            @endif
            <td width="100">
                <a href="{{route('permissoes.edit', $permissao->id)}}" class="btn btn-primary btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>
                <a href="{{route('permissoes.destroy', $permissao->id)}}" class="btn btn-danger btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>
            </td>

        </tr>

        @endforeach

    </table>

</div>
@endsection
