@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h3>Módulo Vacinação de Colaboradores</h3>
            <hr>
        </div>
        <form action="{{ route('index.login') }}" method="post" autocomplete="off">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-3">
                    <div class="form-group">
                        <label><b>CPF do Colaborador:</b></label>
                        <input type="text" data-validation="cpf" name="cpf" id="cpf" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3">
                    <button type="submit" class="btn btn-primary">Prosseguir</button>
                </div>
            </div>
        </form>
    </div>
@stop