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
                <div class="col-xs-offset-3 col-xs-5">
                    <h4>Termo de Desconto em Folha</h4>
                </div>
            </div>
            <div class="row space-top">
                <div class="col-xs-12 text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vitae lacinia ante, scelerisque
                    consequat turpis.
                    Fusce rhoncus risus vitae justo placerat, ut consectetur est congue. Mauris vitae sapien vitae mi
                    placerat
                    feugiat. Maecenas porta sit amet ipsum vitae hendrerit. Donec mollis vestibulum dignissim.
                    Vestibulum et quam
                    vitae dui volutpat fermentum at eu magna. Donec quis nisl ut libero ornare dapibus sit amet ut dui.
                    Praesent
                    in eleifend purus. Donec commodo lectus eget eros gravida tincidunt.
                    <br>
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
                    <div class="form-group">
                        <span class="text-bold">Descontar em Folha:</span><br>
                        ({{ $folha == 'S'?'X':' ' }})Sim ({{ $folha == 'N'?'X':'' }}) Não
                    </div>
                    <div class="form-group">
                        <span class="text-bold">Quantidade de Dependentes:</span><br>
                        {{ count($dependentes) }}
                    </div>
                    <div class="form-group">
                        <span class="text-bold">Nome dos Dependentes</span><br>
                        @foreach($dependentes as $dependente)
                            {{ $dependente->nome }}<br>
                        @endforeach
                    </div>
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