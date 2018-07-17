@extends('layouts.default')

@section('main-content')
    <div class="box" style="height: 82vh;">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Alterar Senha</h1>
            <div id='alert' class="alert "></div>
        </div>
        <div class="box-body">
            {!! Form::open(['action' => ('UsuarioController@changePassword'), 'id' => 'change-pass-form', 'method' => 'POST']) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                            <div class="input-group-addon" style="background: #fff;">
                                <i class="fa fa-key"></i>
                            </div>
                            <input placeholder="Senha Atual" id="password" type="password" class="form-control" name="password" required>
                        </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                            <div class="input-group-addon" style="background: #fff;">
                                <i class="fa fa-unlock"></i>
                            </div>
                            <input placeholder="Nova Senha" id="password" type="password" class="form-control" name="new-password" required>
                        </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon" style="background: #fff;">
                            <i class="fa fa-unlock-alt"></i>
                        </div>
                        <input placeholder="Repita Nova Senha" id="password" type="password" class="form-control" name="repeat-password" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-5">

                    <a href="{{ url('/') }}" class="btn btn-default pull-left button">Cancelar</a>
                </div>

                <div class="col-md-6">

                    <button type="submit" class="btn btn-success" id="salvar-change-pass">Redefinir</button>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/usuarios.js') }}"></script>
@stop