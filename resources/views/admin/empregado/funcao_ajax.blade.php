<option value="" selected >Selecione</option>
@foreach($funcoes as $funcao)
    <option value="{{$funcao->id}}">{{$funcao->nome}}</option>
@endforeach