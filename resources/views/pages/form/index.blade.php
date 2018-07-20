@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Formulários</h1>
            @include('layouts.partials.alert-notify')

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4><i class="icon fa fa-ban"></i> Alerta</h4>
                <ul>
                    
                @foreach ($errors->all() as $error)
                    <li><p>{{ $error }}</p></li>
                @endforeach
                </ul>

            </div>
            @endif


            @if(isset($alert))
            <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4><i class="icon fa fa-ban"></i> Alerta</h4>
                    <ul>
                        <li>{{$alert}}</li>
                    </ul>
    
                </div>
            @endif

        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-8 col-xs-6">  
                    <div class="input-group">
                        <!--  onclick="inserir();" -->
                         <button class="btn btn-primary" onclick="inserir();"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                    </div>
                </div>

                {{-- {!! Form::open(['action' => ('FormList\ListController@index'), 'id' => 'form', 'method' => 'GET']) !!} --}}
                <div class="col-md-4  col-xs-6">
                    <div class="input-group">
                       {{-- {!! Form::text('filtro_input', null, ['class' => 'form-control', 'placeholder' => 'Filtrar...']) !!} --}}
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                        </span>
                    </div>
                </div>
               {{-- {!! Form::close() !!}  --}}
            </div>

            <br/>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-sm-1">#</th>
                        <th class="col-md-2">Título</th>
                        <th class="col-md-4">Instrução</th>
                        <th class="col-md-4">Descrição</th>
                        <th class="col-md-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($result as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td><a  href="{{route('field',$row->id)}}">{{ $row->title }}</a> </td>
                        <td>{{ $row->instructions }}</td>
                        <td>{{ $row->notes }}</td>
                <td>
                    <button  type="button" class="btn btn-primary btn-xs" onclick="editar({{ $row->id }})"> <i class="glyphicon glyphicon-pencil"></i>&nbsp;</button>
                    <button class="btn btn-danger btn-xs" onclick="deletar({{ $row->id }} )"><i class="glyphicon glyphicon-trash"></i>&nbsp;</button>
                </td>
                </tr>
                @endforeach 
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9">
                        <!-- {{--{!! $result->appends(['filtro_input' => $filter])->links() !!} --}}-->  
                    </div>
                    {{--<div class="col-md-3" style="text-align: right;">
                        <br/>
                         Mostrando {!! $result->firstItem() !!} a {!! $result->lastItem() !!}
                        de {!! $result->total() !!}
                    </div>--}}
                </div>
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
    <script type="text/javascript" src="{{ url('js/formlist/form.js') }}"></script>
    
    
@stop