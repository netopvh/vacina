<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Termo de Vacinação</title>
    <link rel="stylesheet" href="{{ asset('components/bootstrap/dist/css/bootstrap.min.css') }}">
    <style>
        h4 {
            font-weight: bold;
        }

        .space-top {
            margin-top: 50px;
        }

        .text-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-offset-2 col-xs-7">
                    <h4>Adesão para a Campanha de Vacinação {{ date('Y') }}</h4>
                </div>
            </div>
            <div class="row space-top">
                <div class="col-xs-12 text-bold text-center">
                    Pelo presente termo, confirmo adesão á campanha de vacinação SESI 2017
                </div>
            </div>
            <div class="row space-top">
                <div class="col-xs-12">
                    <div class="form-group">
                        <span class="text-bold">Colaborador:</span><br>
                        {{ $colaborador }}
                    </div>
                    <div class="form-group">
                        <span class="text-bold">CPF:</span><br>
                        {{ $cpf }}
                    </div>
                    <div class="form-group">
                        <span class="text-bold">Casa:</span><br>
                        {{ $casa }}
                    </div>
                    @if($filhos == 'S')
                        <div class="form-group">
                            <span class="text-bold">Descontar em Folha:</span><br>
                            ({{ $folha == 'S'?'X':' ' }})Sim ({{ $folha == 'N'?'X':'' }}) Não
                        </div>
                    @endif
                    @if($filhos == 'S')
                        <div class="form-group">
                            <span class="text-bold">Quantidade de Dependentes:</span><br>
                            {{ count($dependentes) }}
                        </div>
                    @endif
                    @if($filhos == 'S')
                        <div class="form-group">
                            <span class="text-bold">Nome dos Dependentes</span><br>
                            @foreach($dependentes as $dependente)
                                {{ $dependente->nome }}<br>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-bold">
                    @if($filhos == 'S')
                        Autorizo descontar em folha de pagamento o valor total referente a inclusão de meu(s)
                        dependente(s)
                        na campanha de vacinação antigripal.
                    @endif

                </div>
            </div>
            <div class="row space-top">
                <div class="col-xs-12">
                    {{ $cidade }}, {{ \Carbon\Carbon::now()->formatLocalized('%d de %b de %Y') }}
                </div>
            </div>
            <div class="row space-top">
                <div class="col-xs-5 col-xs-offset-3 text-center">
                    __________________________________________
                    Assinatura do Colaborador
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>