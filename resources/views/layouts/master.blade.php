<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Cadastro de Funcionarios</title>
    <link rel="shortcut icon" href="{{ asset('img/icone.ico') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ asset('components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>
<body>
<header>
    <img src="{{ asset('img/vacinacao.jpg') }}" alt="" class="img-responsive">
</header>
<div class="container">
    @yield('content')
</div>

<script type="text/javascript" src="{{ asset('components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('components/inputmask/dist/jquery.inputmask.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('components/jquery-form-validator/form-validator/jquery.form-validator.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('components/jquery-form-validator/form-validator/lang/pt.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>