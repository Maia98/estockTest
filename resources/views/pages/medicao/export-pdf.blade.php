<html>
<title>{{ $name }}</title>
<div>
@include('layouts.partials.header_pdf')
 <table class="table">
    <thead>
        <tr>
            <th>Nº Obra</th>
            <th>Data Execução</th>
            <th>Status</th>
            <th>Fiscal</th>
            <th>Valor Pago</th>
            <th>Valor Medido</th>
            <th>Apontamentos</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $row)
        <tr>
            <td>{{ $row->obra->numero_obra }}</td>
            <td>{{ date('d/m/Y', strtotime($row->data_medicao)) }}</td>
            <td>{{ $row->statusMedicao->nome }}</td>
            <td>{{ $row->fiscal->nome }} {{ $row->fiscal->sobrenome }}</td>
            <td>R$ {{ $row->valor_pago ? number_format($row->valor_pago,2,",",".") : '0,00'}}</td>
            <td>R$ {{ $row->valor_total ? number_format($row->valor_total,2,",",".") : '0,00' }}</td>
            <td>{{ $row->apontamentos }} </td>
        </tr>
        @endforeach
        </tbody>
</table>
@include('layouts.partials.footer_pdf')
</div>
</html>