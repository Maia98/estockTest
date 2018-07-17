<html>
<title>{{ $name or "Export-pdf" }}</title>
<div>
@include('layouts.partials.header_pdf')

 <table class="table">
    <thead>
        <tr>
            <th style="min-width: 50px;">Nº Obra</th>
            <th>Usuário</th>
            <th>Almoxarifado</th>
            <th>Conferente</th>
            <th>Tipo Entrada</th>
            <th>Data</th>
            <th>Observação</th>
        </tr>
    </thead>
    <tbody> 

        @foreach ($result as $entrada)
            <tr>
                <td>{{ $entrada->obra->numero_obra }}</td>
                <td>{{ $entrada->usuario->name }}</td>
                <td>{{ $entrada->almoxarifado->nome }}</td>
                <td>{{ $entrada->conferente->nome }} {{ $entrada->conferente->sobrenome }}</td>
                <td>{{ $entrada->tipoEntrada->nome }}</td>
                <td>{{ date_format($date = new DateTime($entrada->data),'d/m/Y') }}</td>
                <td style="width: 150px; word-wrap: break-word;"> {{ $entrada->obs }}</td>
            </tr>
        @endforeach

    </tbody>
</table>

@include('layouts.partials.footer_pdf')
</div>
</html>