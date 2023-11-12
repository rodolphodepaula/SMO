@extends('layouts.base')

@section('content')

<form name="personForm" id="personForm" class="form-horizontal" method="post" action=""
data-funcoes-url="{{ route('load_funcoes') }}" data-grupos-url="{{ route('load_grupos') }}">

    <div class="form-group form-group-sm">
        <label class="control-label col-sm-2" for="setor_id">Setor:</label>
      <div class="col-sm-8">
            <select class="form-control" name="setor_id" id="setor_id">
                <option value="">Selecione</option>
                @foreach($setores as $setor)
                    <option value="{{$setor->id}}">{{$setor->nome}}</option>
                @endforeach
            </select>
      </div>
    </div>

    <div class="form-group form-group-sm">
        <label class="control-label col-sm-2" for="funcao_id">Função:</label>
      <div class="col-sm-8">
            <select class="form-control" name="funcao_id" id="funcao_id">
                <option value="">Selecione</option>
                @foreach($funcoes as $funcao)
                    <option value="{{$funcao->id}}">{{$funcao->nome}}</option>
                @endforeach
            </select>
      </div>
    </div>

    <div class="form-group form-group-sm">
        <label class="control-label col-sm-2" for="grupo_id">Grupo:</label>
      <div class="col-sm-8">
            <select class="form-control" name="grupo_id" id="grupo_id">
                <option value="">Selecione</option>
                @foreach($grupos as $grupo)
                    <option value="{{$grupo->id}}">{{$grupo->nome}}</option>
                @endforeach
            </select>
      </div>
    </div>

</form>

<script type="text/javascript">
$(document).ready(function(){
    $("#setor_id").change(function(){
        const url = $('#personForm').attr("data-funcoes-url");
        setorId = $(this).val();
        $.ajax({
            url : url,
            data: { 
                'setor_id': setorId,
            },
            success: function(data){
                $("#funcao_id").html(data);
            }
        });
    });

    $("#funcao_id").change(function () {
        const url = $("#personForm").attr("data-grupos-url");
        const funcaoId = $(this).val();  
        const setorId = $('#setor_id').val();
        $.ajax({
            url: url,
            data: {
                'funcao_id': funcaoId,      
                'setor_id': setorId,      
            },
            success: function (data) {   
                $("#grupo_id").html(data);  
            }
        });
    });

});


</script>
@endsection