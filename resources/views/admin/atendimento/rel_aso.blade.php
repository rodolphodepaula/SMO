<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatorio ASO</title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ URL::asset('css/estilos.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/relatorios.css') }}">
<body>
    <div class="container">
        <h2 class="text-center">Pantheon Tecnologia</h2>
        <h2 class="text-center">Atestado de Saúde Ocupacional</h2>
        <p>EXAME:&nbsp;&nbsp;<b>{{ $atendimento->tipoatendimento->nome}} </b></p>
        <table class="table table-bordered">
            <tr>
                <td width=150px;>NOME</td>
                <td>{{ $atendimento->empregado->nome }}</td>
            </tr>
            <tr>
                <td width=150px;>CPF:</td>
                <td>{{ $atendimento->empregado->cpf }}</td>
            </tr>
            <tr>
                <td width=150px;>SETOR:</td>
                <td>{{ $atendimento->empregado->setor->nome }}</td>
            </tr>
            <tr>
                <td width=150px;>FUNÇÃO:</td>
                <td>{{ $atendimento->empregado->funcao->nome }}</td>
            </tr>
            <tr>
                <td width=150px;>DT NASCIMENTO:</td>
                <td>{{ \Carbon\Carbon::parse($atendimento->empregado->data_nascimento)->format('d/m/Y') }}</td>
            </tr>
        </table>
        <h2 class="text-center">Riscos Ocupacionais</h2>
        @foreach($atendimentoriscos as $atendimentorisco)
            <p class="text-center"><b>( X )</b> {{ $atendimentorisco->risco->nome }} </p>
        @endforeach
        <p style="text-align: justify">Atesto para os efeitos da lei 6514 de 22/12/77, Capítulo V da CLT, Portaria 3214 de 08/06/78, 
            Portaria 24 de 29/12/94 e Portaria 8 de 08/05/96, que o acima referenciado realizou os exames clínicos 
            e complementares específicos para a função, conforme discriminação abaixo:</p>

        <table class="table table-bordered">
            <tr>
                <td width=150px;>EXAME:</td>
                <td width=150px;>DATA:</td>
            </tr>
            @foreach($atendimentoexames as $atendimentoexame)
            <tr>
                <td>{{ $atendimentoexame->exame->nome }}</td>
                <td>{{ \Carbon\Carbon::parse($atendimento->data_atendimento)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
            
        </table>
        <p><b>CONCLUSÃO:</b></p>
        @if ($atendimento->trabalhoaltura == 1)
            <b>( X )</b> Apto para Trabalho em Altura
        @else
            <b>( X )</b> Inapto para Trabalho em Altura
        @endif
        <br>
        @if ($atendimento->espacoconfinado == 1)
            <b>( X )</b> Apto para Trabalho em Espaço Confinado
        @else
            <b>( X )</b> Inapto para Trabalho em Espaço Confinado
        @endif
        <br>
        @if ($atendimento->apto == 1)
            <b>( X )</b> Apto para a Função para o qual foi contratado
        @else
            <b>( X )</b> Inapto para a Função para o qual foi contratado
        @endif
        <br>
        <br>
        <div class="col-md-12"></div>
        <div class="div1">{{ date("d/m/Y") }},</div>
        <div class="div2">_______________________________________</div>
        <div class="div1">&nbsp;</div>
        <div class="div3">Médico do Trabalho</div>
        <p><b>Coordenador do PCMSO:</b>&nbsp;&nbsp;&nbsp;{{$atendimento->coordenador->nome}}</p>
        <br>
        <p>Recebi cópia deste ASO, bem como fui orientado quanto aos resultados dos exames realizados.</p>
        <br>
        <p>_____________________________________________________ - ______/______/________
        </p>
        <br>
    </div>
</body>
</html>