<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> Detalhes</h4>
</div>
    <div class="modal-body">
        <div class="box-body" style="background: #F5F5F5;">
 
            <p><strong>ID:</strong> {{$material->id}}</p>
            <p><strong>Código:</strong> {{$material->codigo}}</p>
            <p><strong>Material:</strong> {{$material->descricao}}</p>
      
        </div>
        <br />
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered" border="1">
                    <thead>
                        <tr>
                            <th>Regional</th>
                            <th>Almoxarifado</th>
                            <th>Quantidade</th>
                            <th>Unidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($result as $row)
                            @if($row->qtde_critica >= $row->quantidade)
                            
                                <tr class="text-red">
                            @else
                                
                                @if($row->qtde_minima >= $row->quantidade)
                                    
                                    <tr class="text-yellow">
                                @else
                                    
                                    <tr>
                                @endif
                            @endif   
                                <td>{{ $row->regional}}</td>
                                <td>{{ $row->almoxarifado}}</td>
                                <td>{{ $row->quantidade}}</td>
                                <td>{{ $row->codigo_unidade}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
    <div class="modal-footer border">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {!! Form::button('Fechar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) !!}
    </div>
{!! Form::close() !!}
