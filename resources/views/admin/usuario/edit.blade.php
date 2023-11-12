@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Usuários</h2>
    </div>
    <div class="form-central" style="margin-top: 0px;">  
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('usuarios.index') }}" style="color: #FFF;">   
            <i style="font-size: 20px;" class="glyphicon glyphicon-backward" aria-hidden="true"></i> 
            </a>
        </div>            
    </div>
    <form class="form-horizontal" method="POST" action="{{ route('usuarios.update', $user->id) }}">
        <div class="form5">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="name">Nome:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="name" value="{{ $user->name }}">
              </div>
            </div>  
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="email">E-Mail:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="email" name="email"value="{{ $user->email }}">
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="password">Senha:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password">
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="password_confirmation">Confirme:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password_confirmation">
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="tipousuario_id">Tipo Usuário:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="tipousuario_id">
                        <option value="">Selecione</option>
                        @foreach($tipousuarios as $tipousuario)
                        @if ($tipousuario->id == $user->tipousuario_id)
                            <option value="{{$tipousuario->id}}" selected>{{$tipousuario->nome}}</option>
                        @else
                            <option value="{{$tipousuario->id}}">{{$tipousuario->nome}}</option>
                        @endif
                        @endforeach
                    </select>
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="status">Status:</label>
                <div class="col-sm-2">
                    <input type="radio" name="status" @if ($user->status==1) checked @endif value="1"> Ativo                     
                </div>
                <div class="col-sm-2">
                    <input type="radio" name="status" @if ($user->status==0) checked @endif value="0"> Inativo                    
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