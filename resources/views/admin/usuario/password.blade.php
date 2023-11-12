@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Alteração de Senha</h2>
    </div>
    
    <form class="form-horizontal" method="post" action="{{ route('usuario.password.update') }}">
        <div class="form4">   
        
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="name">Usuário:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="name" value="{{ $usuario->name }}">
              </div>
            </div>  
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="password_anterior">Senha Anterior:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password_anterior">
              </div>
            </div> 
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="password">Nova Senha:</label>
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
    @if(Session::has('success'))
        <div class="alert alert-success hide-msg" style="float:left; width:100%; margin:10px 0px;">
        {{Session::get('success')}}    
        </div>  
    @endif
</div> 
@endsection