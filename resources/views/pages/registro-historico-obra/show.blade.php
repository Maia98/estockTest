@extends('layouts.default')

@section('main-content')

<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Histórico Obra - Nº {{$numeroObra->numero_obra}}</h1>
        @include('layouts.partials.alert-notify')
    </div>
    <div class="box-body">
        <div class="row margin-top">
            <div class="col-md-8">
                <div class="btn-group" style="margin-left: 20px;">
                    <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Exportar <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" name="{{ $idObra }}" id="btn-excel"><i class="fa fa-file-excel-o"></i>Excel</a></li>
                        <li><a href="#" name="{{ $idObra }}" target="_blank" id="btn-pdf"><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                    </ul>
                </div>
            </div>
            {!! Form::open(['action' => ['RegistroHistoricoObraController@show', $idObra], 'id' => 'form', 'method' => 'GET']) !!}
            <div class="col-md-4">
                <div class="input-group">
                    {!! Form::text('filtro_input', null, ['class' => 'form-control', 'placeholder' => 'Pesquisar...']) !!}
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
                    <th>Status</th>
                    <th>Usuário Sistema</th>
                    <th>Data Movimento</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $row)
                <tr>
                    <td>{{ $row->status_obra}}</td>
                    <td>{{ $row->usuario->name}}</td>
                    <td>{{ date_format($date = new DateTime($row->created_at),'d/m/Y H:i')}}</td>
                    <td>{{ $row->descricao}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9">
                    {!! $result->appends(['filtro_input' => $filter])->links() !!}  
                </div>
                <div class="col-md-3" style="text-align: right;">
                    <br/>
                    Mostrando {!! $result->firstItem() !!} a {!! $result->lastItem() !!}
                    de {!! $result->total() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="{{ url('/obra/gerenciador') }}" class="btn btn-default pull-left button">Voltar</a>
    </div>
</div>
@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ url('js/registro-historico.js') }}"></script>
 
@stop

