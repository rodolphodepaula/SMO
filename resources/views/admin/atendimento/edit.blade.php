@extends('layouts.base')

@section('content')
<div class="conteudo"> 
    <div class="titulo">
        <h2>Administração de Atendimentos</h2>
    </div>
    <div class="form-central" style="margin-top: 0px;">  
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('atendimentos.index') }}" style="color: #FFF;">   
            <i style="font-size: 20px;" class="glyphicon glyphicon-backward" aria-hidden="true"></i> 
            </a>
        </div>            
    </div>
    <form class="form-horizontal" method="post" action="{{ route('atendimentos.update', $atendimento->id ) }}">
        <div class="form7">   
        
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="data_atendimento">Atendimento:</label>
              <div class="col-sm-3">
                  <input class="form-control" type="date" name="data_atendimento" value="{{ $atendimento->data_atendimento }}">
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="empregado_id">Empregado:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="empregado_id" id="empregado_id">
                        <option value="">Selecione</option>
                        @foreach($empregados as $empregado)
                        @if ($empregado->id == $atendimento->empregado_id)
                            <option value="{{$empregado->id}}" selected>{{$empregado->nome}}</option>
                        @else
                            <option value="{{$empregado->id}}">{{$empregado->nome}}</option>
                        @endif
                        @endforeach
                    </select>
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="tipoatendimento_id">Tipo Atendimento:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="tipoatendimento_id" id="tipoatendimento_id">
                        <option value="">Selecione</option>
                        @foreach($tipoatendimentos as $tipoatendimento)
                        @if ($tipoatendimento->id == $atendimento->tipoatendimento_id)
                            <option value="{{$tipoatendimento->id}}" selected>{{$tipoatendimento->nome}}</option>
                        @else
                            <option value="{{$tipoatendimento->id}}">{{$tipoatendimento->nome}}</option>
                        @endif
                        @endforeach
                    </select>
              </div>
            </div>
            
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="trabalhoaltura">Trabalho em Altura:</label>
              <div class="col-sm-3">
                @if ($atendimento->trabalhoaltura == 1)  
                  <input type="checkbox" checked name="trabalhoaltura" style="margin-left: -140px; margin-top:7px;"> 
                @else 
                  <input type="checkbox" name="trabalhoaltura" style="margin-left: -140px; margin-top:7px;"> 
                @endif
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="espacoconfinado">Espaço Confinado:</label>
              <div class="col-sm-3">
                @if ($atendimento->espacoconfinado == 1) 
                  <input type="checkbox" checked name="espacoconfinado" style="margin-left: -140px; margin-top:7px;">
                @else  
                  <input type="checkbox" name="espacoconfinado" style="margin-left: -140px; margin-top:7px;">
                @endif
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="apto">Apto:</label>
              <div class="col-sm-3">
                @if ($atendimento->apto == 1)
                  <input type="checkbox" checked name="apto" style="margin-left: -140px; margin-top:7px;">
                @else
                  <input type="checkbox" name="apto" style="margin-left: -140px; margin-top:7px;">
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

    @if(Session::has('success'))
        <div class="alert alert-success hide-msg" style="float:left; width:100%; margin:10px 0px;">
        {{Session::get('success')}}    
        </div>  
    @endif
</div> 


@endsection