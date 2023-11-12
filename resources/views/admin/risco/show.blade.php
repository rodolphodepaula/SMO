@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Riscos</h2>
    </div>
    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('riscos.index') }}" style="color: #FFF;">
            <i style="font-size: 20px;" class="glyphicon glyphicon-backward" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <form class="form-horizontal" method="GET" action="{{ route('riscos.destroy', $risco->id) }}">
        <div class="form2">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="nome">Risco:</label>
              <div class="col-sm-8">
                  <input class="form-control" disabled = "disabled" type="text" name="nome" value="{{ $risco->nome }}">
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="tiporisco_id">Tipo Risco:</label>
              <div class="col-sm-8">
                    <select class="form-control" disabled="disabled" name="tiporisco_id">
                        <option value="">Selecione</option>
                        @foreach($tiporiscos as $tiporisco)
                            @if ($tiporisco->id == $risco->tiporisco_id)
                                <option value="{{$tiporisco->id}}" selected >{{$tiporisco->nome}}</option>
                            @else
                                <option value="{{$tiporisco->id}}">{{$tiporisco->nome}}</option>
                            @endif
                        @endforeach
                    </select>
              </div>
            </div>
            <div class="form-central" style="margin-top: 35px;">
                <div class="form-group">
                  <button type="submit" class="btn btn-danger">
                    <i style="font-size: 20px;" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Excluir
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
