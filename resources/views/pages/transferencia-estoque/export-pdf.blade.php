<html>
<title>{{ $name or "Export-pdf" }}</title>
<div>
@include('layouts.partials.header_pdf')

 <table class="table">
    <thead>
        <tr>
            <th style="min-width: 50px;">Obra Destino</th>
            <th>Almoxarifado Destino</th>
            <th>Usuário</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody> 

        @foreach ($result as $transferencia)
            <tr>
                <td>{{ $transferencia->obraDestino->numero_obra }}</td>
                <td>{{ $transferencia->almoxarifadoDestino->nome }}</td>
                <td>{{ $transferencia->usuario->name }}</td>
                <td>{{ date_format($date = new DateTime($transferencia->data),'d/m/Y') }}</td>
            </tr>
        @endforeach

    </tbody>
</table>

@include('layouts.partials.footer_pdf')
</div>
</html>