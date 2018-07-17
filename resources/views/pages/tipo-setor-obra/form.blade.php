<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoSetorObra)) ? 'Editar' : 'Adicionar' }} Tipo Setor Obra</h4>
</div>
@if(isset($tipoSetorObra))
    {!! Form::model($tipoSetorObra, ['action' => ('TipoSetorObraController@store'), 'id' => 'form-tipo-setor-obra']) !!}
@else
    {!! Form::open(['action' => ('TipoSetorObraController@store'), 'id' => 'form-tipo-setor-obra']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('descricao', 'Descrição:') !!}
        {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-tipo-setor-obra']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-funcao-tipo-setor-obra']) !!}
    </div>
{!! Form::close() !!}