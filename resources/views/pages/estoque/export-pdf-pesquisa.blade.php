<html>
<title>{{ $name or "Export-pdf" }}</title>
<div>
@include('layouts.partials.header_pdf')

 <table class="table">
    <thead>
        <tr>
            <th>Código</th>
            <th>Descrição</th>
            <th>Nº Obra</th>
            <th>Status Obra</th>
            <th>Tipo Movimento</th>
            <th>Data Movimento</th>
        </tr>
    </thead>
    <tbody> 
        @foreach ($result as $row)
            <tr>
                <td>{{ $row['codigo'] }}</td>
                <td>{{ $row['descricao'] }}</td>
                <td>{{ $row['numero_obra'] }}</td>
                <td>{{ $row['status_obra'] }}</td>
                <td>{{ $row['tipo_movimento'] }}</td>
                <td>{{ date('d/m/Y', strtotime($row['data'])) }}</td>
            </tr>
        @endforeach

    </tbody>
</table>

@include('layouts.partials.footer_pdf')

</html>