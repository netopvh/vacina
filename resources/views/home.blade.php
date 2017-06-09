@extends('layouts.master')

@section('content')
    <div class="row bottom-space-30">
        <div class="col-xs-12">
            <fieldset>
                <legend>Bem vindo {{ $funcionario->NOME }}</legend>
                <div class="row">
                    <div class="col-xs-4">
                        <a href="{{ route('register.logout') }}" type="submit" class="btn btn-primary">Sair do
                            Sistema</a>
                        <a href="{{ route('register.termo',['id' => $funcionario->CODIGO]) }}"
                           class="btn btn-primary">Imprimir
                            Termo</a>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Informações do Colaborador</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="small text-danger">Atenção! Atualize suas informações referente a desconto em
                                folha.
                            </div>
                            <form action="{{ route('register.atualiza', ['id' => $funcionario->CODIGO]) }}"
                                  method="post">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Nome:</label>
                                            <input type="text" value="{{ $funcionario->NOME }}" class="form-control"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Casa:</label>
                                            <input type="text" value="{{ $funcionario->RAZAO }}" class="form-control"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label>CPF:</label>
                                            <input type="text" class="form-control" value="{{ $funcionario->CPF }}"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label>Dependentes:</label>
                                            <select name="dependente" id="dependente" class="form-control" required>
                                                <option value=""></option>
                                                <option value="S"{{ $funcionario->DEPENDENTE=='S'?' selected':'' }}>
                                                    Sim
                                                </option>
                                                <option value="N"{{ $funcionario->DEPENDENTE=='N'?' selected':'' }}>
                                                    Não
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-3" id="desconto">
                                        <label>Descontar em Folha:</label>
                                        <div class="form-group" style="margin-top: 10px">
                                            <label class="radio-inline">
                                                <input type="radio" id="sim" name="folha"
                                                       value="S"{{ $funcionario->FOLHA=='S'? ' checked' : '' }}> Sim
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="nao" name="folha"
                                                       value="N"{{ $funcionario->FOLHA=='N'? ' checked' : '' }}> Não
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <label>Local de Aplicação:</label>
                                            <select name="unidade" class="form-control" required>
                                                <option value="">Selecione</option>
                                                @foreach($unidades as $unidade)
                                                    <option value="{{ $unidade->cod }}"{{ $funcionario->CDFILIAL==$unidade->cod?' selected':'' }}>{{ $unidade->filial }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <button class="btn btn-primary" type="submit">Atualizar Informações</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($funcionario->DEPENDENTE == 'S')
        <div class="row">
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Dependentes</h3>
                    </div>
                    <div class="panel-body">
                        <span class="small text-danger">Atenção! O Valor da dose para os dependentes é de <b>R$90,00</b></span>
                        <br>
                        <form action="{{ route('register.dependente') }}" method="post" autocomplete="off">
                            {{ csrf_field() }}
                            <input type="hidden" name="codigo" value="{{ $funcionario->CODIGO }}">
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="form-group">
                                        <label>Nome:</label>
                                        <input type="text" class="form-control" name="nome" value="{{ old('nome') }}"
                                               data-validation="required">
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group">
                                        <label>Idade:</label>
                                        <input type="text" class="form-control" maxlength="2" name="idade"
                                               value="{{ old('idade') }}" data-validation="number">
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group">
                                        <button class="btn btn-info" style="margin-top: 25px">Gravar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            @if(Session::has('error'))
                                <div class="alert alert-danger">{{ Session::get('error') }}</div>
                            @endif
                            <table class="table table-condesed">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th width="150">Idade</th>
                                    <th width="80">Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($dependentes) < 1)
                                    <tr>
                                        <td colspan="2" class="text-center">Sem Registros Cadastrados</td>
                                    </tr>
                                @else
                                    @foreach($dependentes as $dependente)
                                        <tr>
                                            <td>{{ $dependente->NOME }}</td>
                                            <td>{{ $dependente->IDADE }}</td>
                                            <td>
                                                <form action="{{ route('register.delete', ['id' => $dependente->CODIGO]) }}"
                                                      method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button class="btn btn-danger"><i class="fa fa-remove"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop