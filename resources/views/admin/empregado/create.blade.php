@extends('layouts.base')

@section('content')
<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Empregados</h2>
    </div>
    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('empregados.index') }}" style="color: #FFF;">
                <i style="font-size: 20px;" class="glyphicon glyphicon-backward" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <form name="personForm" id="personForm" class="form-horizontal" method="post" action="{{ route('empregados.store') }}" data-funcoes-url="{{ route('load_funcoes') }}" data-grupos-url="{{ route('load_grupos') }}">
        <div class="form6">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="nome">Nome:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="nome" value="{{ old('nome') }}">
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="cpf">CPF:</label>
                <div class="col-sm-3">
                    <input class="form-control" type="text" name="cpf" id="cpf" value="{{ old('cpf') }}">
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="ctps">CTPS:</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" name="ctps" value="{{ old('ctps') }}">
                </div>
                <label class="control-label col-sm-2" for="serie">Série:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" name="serie" value="{{ old('serie') }}">
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="data_nascimento">Nascimento:</label>
                <div class="col-sm-3">
                    <input class="form-control" type="date" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}">
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="data_admissao">Admissão:</label>
                <div class="col-sm-3">
                    <input class="form-control" type="date" name="data_admissao" value="{{ old('data_admissao') }}">
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="data_demissao">Demissão:</label>
                <div class="col-sm-3">
                    <input class="form-control" type="date" name="data_demissao">
                </div>
            </div>
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#setor_id").change(function() {
            const url = $('#personForm').attr("data-funcoes-url");
            setorId = $(this).val();
            $.ajax({
                url: url
                , data: {
                    'setor_id': setorId
                , }
                , success: function(data) {
                    $("#funcao_id").html(data);
                }
            });
        });

        $("#funcao_id").change(function() {
            const url = $("#personForm").attr("data-grupos-url");
            const funcaoId = $(this).val();
            const setorId = $('#setor_id').val();
            $.ajax({
                url: url
                , data: {
                    'funcao_id': funcaoId
                    , 'setor_id': setorId
                , }
                , success: function(data) {
                    $("#grupo_id").html(data);
                }
            });
        });



    });

</script>

@endsection
