<?php
use App\Model\Form\Lista;
use App\Model\Form\FieldType;
?>

@extends('layouts.default')
@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1>
                <i class="glyphicon glyphicon-menu-right"></i>Formulário-{{$form->title}}
                <i class="glyphicon glyphicon-menu-right"></i>Campos
            </h1>
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
                        <!--  onclick="inserir();"   'id' => 'form',-->
                    <button onclick="insert({{$form->id}})" class="btn btn-primary" ><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                    </div>
                </div>

                {!! Form::open(['action' => ('FormList\FieldController@index'),'id' => 'form', 'method' => 'GET']) !!}
                    <div class="col-md-4  col-xs-6">
                        <div class="input-group">
                            {{-- {!! Form::hidden('id_form', $fields->form_id) !!} --}}
                            {!! Form::text('filtro_input', null, ['class' => 'form-control', 'placeholder' => 'Filtrar...']) !!}
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
                        <th class="col-sm-1">#</th>
                        <th class="col-md-2">Rótulo</th>
                        <th class="col-md-3">Tipo</th>
                        <th class="col-md-1">Variável</th>
                        <th class="col-md-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($fields as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->label }}</td>
                        
                        <td> 
                            @foreach($list as $l)
                                @if(substr($row->type_id,0,5) === 'list-')   
                                    {{($l->id == substr($row->type_id,5))?'Lista - '.$l->name:''}}
                                @endif
                            @endforeach
                            @foreach ($type as $t)
                                @if(substr($row->type_id,0,5) === 'type-' )
                                    {{($t->id == substr($row->type_id,5))?'Tipo - '.$t->desc:''}}
                                @endif    
                            @endforeach
                            
                            &nbsp;&nbsp;<button type="button" onclick='configField({{$row->id}})' class="btn btn-primary btn-xs"><i class="fa fa-fw fa-edit"></i>configuração</button></td>
                             
                        <td>{{ $row->name }}</td>
                <td> 
                    <button  type="button" class="btn btn-primary btn-xs" onclick="editarField({{ $row->id }})"> <i class="glyphicon glyphicon-pencil"></i>&nbsp;</button>
                    <button class="btn btn-danger btn-xs" onclick="deletarField({{ $row->id }} )"><i class="glyphicon glyphicon-trash"></i>&nbsp;</button>
                </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $fields->links() }}
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9">
                        <!-- {{--{!! $result->appends(['filtro_input' => $filter])->links() !!} --}} 
                    {{-- </div> --}}
                    {{--<div class="col-md-3" style="text-align: right;">
                        <br/>
                         Mostrando {!! $result->firstItem() !!} a {!! $result->lastItem() !!}
                        de {!! $result->total() !!}
                    </div>--}}
                {{-- </div>
            </div> --}}
        </div>
        
    </div>
<!-- 
    {{--
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-almoxarifado', 'idContent' => 'content-modal-almoxarifado' ])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-cidade', 'idContent' => 'content-modal-cidade' ])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-regional', 'idContent' => 'content-modal-regional' ]) --}}
    -->
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-field', 'idContent' => 'content-modal-field'])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-field', 'idContent' => 'content-modal-field' ])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-confField', 'idContent' => 'content-modal-confField'])
@stop

@section('scripts-footer')
    
    {{--<script type="text/javascript" src="{{ url('js/tabelas-tipos/regional.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/cidade.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/almoxarifado.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/formlist/formitem.js') }}"></script>
    --}}
    <script type="text/javascript" src="{{ url('js/formlist/field.js') }}"></script>
    
    
@stop