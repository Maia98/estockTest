<html>
<title>{{ $name or "Export-pdf" }}</title>
<div>
@include('layouts.partials.header_pdf')

 <table class="table">
    <thead>
        <tr>
            <th>Nº Obra</th>
            <th>Usuário</th>
            <th>Almoxarifado</th>
            <th>Conferente</th>
            <th>Tipo Saída</th>
            <th>Data</th>
            <th>Prev. Execução</th>
            <th>Observação</th>
        </tr>
    </thead>
    <tbody> 

        @foreach ($result as $saida)
            <tr>
                <td>{{ $saida->obra->numero_obra }}</td>
                <td style="width: 120px">{{ $saida->usuario->name }}</td>
                <td style="width: 100px">{{ $saida->almoxarifado->nome }}</td>
                <td style="width: 100px">{{ $saida->conferente->nome }} {{ $saida->conferente->sobrenome }}</td>
                <td style="width: 20px">{{ $saida->tipoSaida->nome }}</td>
                <td style="width: 20px">{{ date_format($date = new DateTime($saida->data),'d/m/Y') }}</td>
                <td style="width: 20px" >{{ ($saida->execucao) ? date_format($date = new DateTime($saida->execucao),'d/m/Y') : "" }}</td>
                <td style="width: 350px; word-wrap: break-word;"> {{ $saida->obs }}</td>
            </tr>
        @endforeach

    </tbody>
</table>

@include('layouts.partials.footer_pdf')
</div>
</html>