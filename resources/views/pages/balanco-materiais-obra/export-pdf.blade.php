<html>
<title> {{ $name or "Export-PDF" }} </title>
<div>
    @include('layouts.partials.header_pdf')
        <table class="table">
            <thead>
                <tr>
                    <th>Obra</th>
                    <th>Cód. Material</th>
                    <th>Descrição</th>
                    <th>Und Medida</th>
                    <th>Orçado</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Saldo</th>
                    <th>Trans. Entrada</th>
                    <th>Trans. Saída</th>
                    <th>Trans. Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($balanco as $row)
                    @php
                        $saldo = $row->entrada - $row->saida;
                    @endphp
                    <tr>
                        <td>{{ $row->numero_obra }}</td>
                        <td>{{ $row->codigo }}</td>
                        <td>{{ $row->descricao }}</td>
                        <td>{{ $row->unidade }}</td>
                        <td>{{ $row->orcado }}</td>
                        <td>{{ $row->entrada }}</td>
                        <td>{{ $row->saida }}</td>
                        <td>{{ $saldo }}</td>
                        <td>{{ $row->transferenciaent }}</td>
                        <td>{{ $row->transferenciasai }}</td>
                        <td>{{ $row->transferenciaent - $row->transferenciasai }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @include('layouts.partials.footer_pdf')
</div>
</html>