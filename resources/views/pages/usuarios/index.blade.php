@extends('layouts.default')

@section('main-content')
<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Usuários</h1>
        <div id='alert' class="alert "></div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">  
                <div class="input-group">
                    <button class="btn btn-primary" onclick="inserir();"><i class="glyphicon glyphicon-plus"></i> Adicionar </button>
                </div>
            </div>
            
            {!! Form::open(['action' => ('UsuarioController@index'), 'id' => 'form', 'method' => 'GET']) !!}
            <div class="col-md-4">
                <div class="input-group">
                    {!! Form::text('filter', null, ['class' => 'form-control', 'placeholder' => 'Filtrar...']) !!}
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                    </span>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        
        <br/>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th style="width: 60px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>
                        <center>
                            <button type="button" class="btn btn-primary btn-xs" onclick="editar({{$row->id}})" data-toggle="tooltip" title="Editar"> <i class="glyphicon glyphicon-pencil"></i>&nbsp;</button>
                        </center>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form', 'idContent' => 'content-modal'])
   @stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/usuarios.js') }}"></script>
@stop