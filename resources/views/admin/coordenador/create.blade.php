@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Coordenador de PCMSO</h2>
    </div>
    <div class="form-central" style="margin-top: 0px;">  
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('coordenadores.index') }}" style="color: #FFF;">   
            <i style="font-size: 20px;" class="glyphicon glyphicon-backward" aria-hidden="true"></i> 
            </a>
        </div>            
    </div>
    <form class="form-horizontal" method="post" action="{{ route('coordenadores.store') }}">
        <div class="form4">   
        
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="nome">Nome:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="nome" value="{{ old('nome') }}">
              </div>
            </div>  

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="crm">CRM:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="crm" value="{{ old('crm') }}">
              </div>
            </div> 
            
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="data_inicio">Início:</label>
              <div class="col-sm-3">
                  <input class="form-control" type="date" name="data_inicio" value="{{ old('data_inicio') }}">
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="data_fim">Término:</label>
              <div class="col-sm-3">
                  <input class="form-control" type="date" name="data_fim" value="{{ old('data_fim') }}">
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