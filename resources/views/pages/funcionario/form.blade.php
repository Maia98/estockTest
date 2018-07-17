<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($funcionario)) ? 'Editar' : 'Adicionar' }} Funcionário</h4>
</div>
@if(isset($funcionario))
    {!! Form::model($funcionario, ['action' => ('FuncionarioController@store'), 'id' => 'form-funcionario']) !!}
@else
    {!! Form::open(['action' => ('FuncionarioController@store'), 'id' => 'form-funcionario']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal2' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('nome', 'Nome:') !!}
        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
        <br />
        {!! Form::label('sobrenome', 'Sobrenome:') !!}
        {!! Form::text('sobrenome', null, ['class' => 'form-control']) !!}
        <br />
        {!! Form::label('cpf', 'CPF:') !!}
        {!! Form::text('cpf', null, ['class' => 'form-control', 'id' => 'cpf']) !!}
        <br>

        <fieldset class="fsStyle" style="width: 570px; margin-left: 0px;">
            <legend><strong>Funções</strong></legend>
            {!! Form::checkbox('supervisor', true, null, ['id' => 'supervisor']) !!} {!! Form::label('supervisor', 'Supervisor') !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {!! Form::checkbox('fiscal', true, null, ['id' => 'fiscal']) !!} {!! Form::label('fiscal', 'Fiscal') !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {!! Form::checkbox('encarregado', true, null, ['id' => 'encarregado']) !!} {!! Form::label('encarregado', 'Encarregado') !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {!! Form::checkbox('conferente', true, null, ['id' => 'conferente']) !!} {!! Form::label('conferente', 'Conferente') !!}
        </fieldset>
            
    </div>
    <div class="modal-footer border">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-funcionario']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-funcao-funcionario']) !!}
    </div>
{!! Form::close() !!}

<!-- <script type="text/javascript">
    $('#cpf').inputmask({'mask': "###.###.###-##", greedy: false, reverse: true, autoUnmask: true});
</script> -->