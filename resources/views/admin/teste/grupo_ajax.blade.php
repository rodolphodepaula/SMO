<option value="">Selecione</option>
@foreach($grupos as $grupo)
    <option value="{{$grupo->id}}">{{$grupo->nome}}</option>
@endforeach