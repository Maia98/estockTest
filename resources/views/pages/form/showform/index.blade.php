@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Formulários</h1>
        </div>
        <div class="box-body">
            {!! Form::open(['action' => ('FormList\ShowFormController@index'), 'id' => 'form', 'method' => 'GET']) !!}
            <div class="col-md-4  col-xs-6">
                <div class="input-group">
                    {!! Form::text('filtro_input', null, ['class' => 'form-control', 'placeholder' => 'Filtrar...']) !!}
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                    </span>
                </div>
            </div>
            {!! Form::close() !!} 
        </div>
        <br/>
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-2">Título</th>
                        <th class="col-md-4">Instrução</th>
                        <th class="col-md-3">Descrição</th>
                        <th class="col-md-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($form as $row)
                    <tr>
                    <td>{{$row->title}}</td>
                    <td>{{$row->instructions}}</td>
                    <td>{{$row->notes}}</td>
                    <td>
                        <a class='btn btn-md btn-primary' href="{{route('create',['id' => $row->id])}}">Registrar</a>
                        <a class='btn btn-md btn-info' href="{{route('show',['id' => $row->id])}}">Visualizar</a>
                    </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $form->links() }}
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9">
                        {!! $form->appends(['filtro_input' => $filter])->links() !!} 
                    </div>
                    <div class="col-md-3" style="text-align: right;">
                        <br/>
                         Mostrando {!! $form->firstItem() !!} a {!! $form->lastItem() !!}
                        de {!! $form->total() !!}
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
<!-- 
    {{--
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-almoxarifado', 'idContent' => 'content-modal-almoxarifado' ])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-cidade', 'idContent' => 'content-modal-cidade' ])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-regional', 'idContent' => 'content-modal-regional' ]) --}}
    -->
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-form', 'idContent' => 'content-modal-form'])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-form', 'idContent' => 'content-modal-form' ])
   
@stop

@section('scripts-footer')
    
    {{--<script type="text/javascript" src="{{ url('js/tabelas-tipos/regional.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/cidade.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/almoxarifado.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/formlist/formitem.js') }}"></script>
    --}}
    <script type="text/javascript" src="{{ url('js/formlist/showform.js') }}"></script>
    
    
@stop