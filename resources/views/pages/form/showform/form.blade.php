@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Formulário @if($form)  {{$form->title}} @else {{ '' }} @endif</h1>
          
        </div>
        <div class="box-body">
            
            
                <form method="" action="" class="form">
                    @foreach ($formfields as $row)
                        <strong>{{$row->label}}</strong>    {!! $row->configuration !!}
                    <br>
                    @endforeach
                    <br>
                    <input class="btn btn-md btn-success" type="submit" value="Salvar">
                </form> 
                
                
                
        </div>

            <br/>
            
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