@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="col-md-12"></div>
    <div class="div4">
        <h4>Empregados</h4>
        <h3>{{$total_empregados}}</h3>
    </div>
    <div class="div5">
        <h4>ASO's Emitidos</h4>
        <h3>{{$total_atendimentos}}</h3>
    </div>
    <div id="graf1"></div>
    <div id="graf2"></div>
</div>

@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawAxisTickColors);

    function drawAxisTickColors() {
        var hoje = new Date();
        var ano = hoje.getFullYear() - 1;
        var data = google.visualization.arrayToDataTable([
            ['Tipo', 'Quantidade', {
                role: 'style'
            }]
            , @foreach($tipoatendimentos1 as $tipoatendimento)["{{ $tipoatendimento->nome }}", {
                {
                    $tipoatendimento - > qtd
                }
            }, "{{ $tipoatendimento->cor }}"]
            , @endforeach
        ]);

        var options = {
            title: 'ASOs emitidos em ' + ano
            , chartArea: {
                width: '50%'
            }
            , legend: {
                position: "none"
            }
            , bar: {
                groupWidth: "65%"
            }
            , hAxis: {
                minValue: 0
                , textStyle: {
                    bold: true
                    , fontSize: 12
                    , color: '#4d4d4d'
                }
                , titleTextStyle: {
                    bold: true
                    , fontSize: 18
                    , color: '#4d4d4d'
                }
            }
            , vAxis: {
                title: 'Quantidade'
                , textStyle: {
                    fontSize: 14
                    , bold: true
                    , color: '#848484'
                }
                , titleTextStyle: {
                    fontSize: 14
                    , bold: true
                    , color: '#848484'
                }
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('graf1'));
        chart.draw(data, options);
    }

    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawAxisTickColors2);

    function drawAxisTickColors2() {
        var hoje = new Date();
        var ano = hoje.getFullYear();

        var data = google.visualization.arrayToDataTable([
            ['Tipo', 'Quantidade', {
                role: 'style'
            }]
            , @foreach($tipoatendimentos2 as $tipoatendimento)["{{ $tipoatendimento->nome }}", {
                {
                    $tipoatendimento - > qtd
                }
            }, "{{ $tipoatendimento->cor }}"]
            , @endforeach
        ]);

        var options = {
            title: 'ASOs emitidos em ' + ano
            , chartArea: {
                width: '50%'
            }
            , legend: {
                position: "none"
            }
            , bar: {
                groupWidth: "65%"
            }
            , colors: ['#006600']
            , hAxis: {
                minValue: 0
                , textStyle: {
                    bold: true
                    , fontSize: 12
                    , color: '#4d4d4d'
                }
                , titleTextStyle: {
                    bold: true
                    , fontSize: 18
                    , color: '#4d4d4d'
                }
            }
            , vAxis: {
                title: 'Quantidade'
                , textStyle: {
                    fontSize: 14
                    , bold: true
                    , color: '#848484'
                }
                , titleTextStyle: {
                    fontSize: 14
                    , bold: true
                    , color: '#848484'
                }
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('graf2'));
        chart.draw(data, options);
    }

</script>
