<<<<<<< HEAD
<?php
use App\Model\Form\Lista;
use App\Model\Form\FieldType;
?>

@extends('layouts.default')
=======
@extends('layouts.default')

>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
@section('main-content')

    <div class="box">
        <div class="box-header page-header">
<<<<<<< HEAD
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

            
=======
        <h1><i class="glyphicon glyphicon-menu-right"></i>Formulário-{{$form->title}}
                <i class="glyphicon glyphicon-menu-right"></i>Campos</h1>
            @include('layouts.partials.alert-notify')

            {{--@if ($errors->any())
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


>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
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
<<<<<<< HEAD
       
=======
            --}}
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007

        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-8 col-xs-6">  
                    <div class="input-group">
<<<<<<< HEAD
                        <!--  onclick="inserir();"   'id' => 'form',-->
=======
                        <!--  onclick="inserir();" -->
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
                    <button onclick="insert({{$form->id}})" class="btn btn-primary" ><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                    </div>
                </div>

<<<<<<< HEAD
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
=======
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
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
            </div>

            <br/>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-sm-1">#</th>
<<<<<<< HEAD
                        <th class="col-md-2">Rótulo</th>
                        <th class="col-md-3">Tipo</th>
                        <th class="col-md-1">Variável</th>
=======
                        <th class="col-md-2">Campo</th>
                        <th class="col-md-4">Tipo</th>
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
                        <th class="col-md-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
<<<<<<< HEAD
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
=======
                {{--@foreach ($result as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td><a onclick="createFeild({{$row->id}})" href="#">{{ $row->title }}</a> </td>
                        <td>{{ $row->instructions }}</td>
                        <td>{{ $row->notes }}</td>
                <td>
                    <button  type="button" class="btn btn-primary btn-xs" onclick="editar({{ $row->id }})"> <i class="glyphicon glyphicon-pencil"></i>&nbsp;</button>
                    <button class="btn btn-danger btn-xs" onclick="deletar({{ $row->id }} )"><i class="glyphicon glyphicon-trash"></i>&nbsp;</button>
                </td>
                </tr>
                @endforeach --}}
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9">
                        <!-- {{--{!! $result->appends(['filtro_input' => $filter])->links() !!} --}}-->  
                    </div>
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
                    {{--<div class="col-md-3" style="text-align: right;">
                        <br/>
                         Mostrando {!! $result->firstItem() !!} a {!! $result->lastItem() !!}
                        de {!! $result->total() !!}
                    </div>--}}
<<<<<<< HEAD
                {{-- </div>
            </div> --}}
        </div>
        
=======
                </div>
            </div>
        </div>
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
    </div>
<!-- 
    {{--
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-almoxarifado', 'idContent' => 'content-modal-almoxarifado' ])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-cidade', 'idContent' => 'content-modal-cidade' ])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-regional', 'idContent' => 'content-modal-regional' ]) --}}
    -->
<<<<<<< HEAD
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-field', 'idContent' => 'content-modal-field'])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-field', 'idContent' => 'content-modal-field' ])
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-confField', 'idContent' => 'content-modal-confField'])
=======
    @includeIf('layouts.partials.modallg', ['idModal' => 'modal-form-field', 'idContent' => 'content-modal-field'])
    @includeIf('layouts.partials.modallg', ['idModal' => 'modal-form-field', 'idContent' => 'content-modal-field' ])
   
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
@stop

@section('scripts-footer')
    
    {{--<script type="text/javascript" src="{{ url('js/tabelas-tipos/regional.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/cidade.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/almoxarifado.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/formlist/formitem.js') }}"></script>
    --}}
    <script type="text/javascript" src="{{ url('js/formlist/field.js') }}"></script>
    
    
@stop