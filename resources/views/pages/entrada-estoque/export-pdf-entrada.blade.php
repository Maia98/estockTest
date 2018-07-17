<html>
<title>{{ $name or "Export-pdf" }}</title>
<div>
@include('layouts.partials.header_pdf')
<table style="width: 110%; font-size: 13px; margin-top: 8%;">
    <tbody>
    <tr>
        <td width="12%"><strong>Obra: </strong>{{ $balanco->obra->numero_obra }}</td>
        <td width="30%"><strong>Almoxarifado: </strong>{{ $balanco->almoxarifado->nome }}</td>
        <td width="20%"><strong>Tipo Entrada: </strong>{{ $balanco->tipoEntrada->nome   }}</td>
        <td width="30%"><strong>Data Recebimento: </strong>{{ dateToView($balanco->data) }}</td>
    </tr>
    <tr>
        <td colspan="4"><strong>Observação: </strong>{{ $balanco->obs }}</td>
    </tr>
    </tbody>
</table>
<table class="table" style="width: 110%; margin-top: 2%;">
    <thead>
        <tr>
            <th style="width: 5%;">Código</th>
            <th style="width: 50%;">Descrição</th>
            <th style="width: 10%;">RMA</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($result as $row)
        <tr>
            <td> {{ $row->codigo }} </td>
            <td> {{ $row->descricao }} </td>
            <td> {{ $row->qtde }} </td>
        </tr>
    @endforeach
    </tbody>
</table>

@include('layouts.partials.footer_pdf')
</div>
</html>