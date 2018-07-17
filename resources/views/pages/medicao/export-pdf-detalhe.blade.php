<html>
<title>{{ $name }}</title>
<div>
@include('layouts.partials.header_pdf')

 <table class="table">
    <thead>
    <tr>
        <th>Tipo Mão de Obra</th>
        <th>Código</th>
        <th>Descrição Serviço</th>
        <th>Qtde</th>
        <th>Valor Unitário</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
        
        @foreach($result as $row)
        <tr>
            <td>{{ $row->tipoMaoObra() }}</td>
            <td>{{ $row->cod_mobra }}</td>
            <td>{{ $row->descricao_mobra }}</td>
            <td>{{ $row->qtde}}</td>
            <td>R$ {{ number_format($row->valor_unitario,2,",",".") }}</td>
            <td>R$ {{ number_format($row->sub_total,2,",",".") }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('layouts.partials.footer_pdf')
</div>
</html>