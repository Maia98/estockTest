@extends('layouts.default')

@section('main-content')

<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Tipo Material</h1>
        @include('layouts.partials.alert-notify')
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">  
                <div class="input-group">
                    <button class="btn btn-primary" onclick="inserir();"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                </div>
            </div>
            {!! Form::open(['action' => ('TipoMaterialController@index'), 'id' => 'form', 'method' => 'GET']) !!}
            <div class="col-md-4">
            	<div class="input-group">
            		{!! Form::text('filtro_input', null, ['class' => 'form-control', 'placeholder' => 'Filtrar...']) !!}
            		<span class="input-group-btn">
            		      <button type="submit" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
            		</span>
            	</div>
            </div>
            {!! Form::close() !!}
        </div>

        <!-- <div class="row margin-top">
            
            <div class="col-md-4">
                <div class="btn-group">
                  <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Exportar <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="{{ url('/sistema/tipo-material/exportar-excel') }}"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                    <li><a href="{{ url('/sistema/tipo-material/exportar-pdf') }}"><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                  </ul>
                </div>
            </div>
        </div> -->
        <br/>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 50px">#</th>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Unidade</th>
                    <th>Constante</th>
                    <th>Valor(R$)</th>
                    <th>Qtde. Mínima</th>
                    <th>Qtde. Crítica</th>
                    <th style="width: 90px">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->codigo }}</td>
                    <td>{{ $row->descricao }}</td>
                    <td>{{ $row->unidade->codigo }}</td>
                    <td><span class="valor_unitario">{{ $row->constante_material == null ? 000 : number_format($row->constante_material,2,",",".") }}</span></td>
                    <td><span class="valor_unitario">{{ $row->valor_material == null ? 000 : number_format($row->valor_material,2,",",".") }}</span></td>
                    <td>{{ $row->qtde_minima }}</td>
                    <td>{{ $row->qtde_critica }}</td>
                    <td>    
                        <button  type="button" class="btn btn-primary btn-xs" onclick="editar({{ $row->id }})"> <i class="glyphicon glyphicon-pencil"></i>&nbsp;</button>
                        <button class="btn btn-danger btn-xs" onclick="deletar({{ $row->id }})"><i class="glyphicon glyphicon-trash"></i>&nbsp;</button>
                    </td>
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
</div>

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-tipo-material', 'idContent' => 'content-modal-tipo-material', 'typeModal' => 'modal-lg'  ])
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-tipo-unidade-medida', 'idContent' => 'content-modal-tipo-unidade-medida' ])   
   
@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ url('js/tabelas-tipos/tipo-unidade-medida.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/tipo-material.js') }}"></script>

@stop