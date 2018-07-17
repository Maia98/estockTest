@extends('layouts.default')

@section('main-content')
<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Funções</h1>
        @include('layouts.partials.alert-notify')
        <div id='alert' class="alert "></div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">  
                <div class="input-group">
                    <button class="btn btn-primary" onclick="inserir();"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                </div>
            </div>
            
            {!! Form::open(['action' => ('FuncaoController@index'), 'id' => 'form', 'method' => 'GET']) !!}
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
        
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th style="width: 60px">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->description }}</td>
                    <td>
                        <center>
                            <button type="button" class="btn btn-primary btn-xs" onclick="editar({{$row->id}})" data-toggle="tooltip" title="Editar"> <i class="glyphicon glyphicon-pencil"></i>&nbsp;</button>
                        </center>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9">
                    {!! $roles->render() !!}
                </div>
                <div class="col-md-3" style="text-align: right;">
                    <br/>
                    Mostrando {!! $roles->firstItem() !!} a {!! $roles->lastItem() !!}
                    de {!! $roles->total() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-funcao', 'idContent' => 'content-modal-funcao'])
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/tabelas-tipos/funcoes.js') }}"></script>
@stop