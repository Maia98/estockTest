<html>
<title>{{ $name or "Export-pdf" }}</title>
<div>
@include('layouts.partials.header_pdf')
<table style="width: 100%; font-size: 14px; width: 100%; margin-top: 50px;">
    <tbody>
    <tr>
        <td>Almoxarifado Origem: <strong>{{ $balanco->almoxarifadoOrigem->nome }}</strong></td>
        <td>Obra Origem: <strong>{{ $balanco->numero_obra_origem }}</strong></td>
        <td>Almoxarifado Destino: <strong>{{ $balanco->almoxarifadoDestino->nome   }}</strong></td>
        <td>Obra Destino: <strong>{{ $balanco->numero_obra_destino }}</strong></td>
    </tr>
    </tbody>
</table>

 <table class="table" style="margin-top: 10px!important;">
    <thead>
        <tr>
            <th>Código</th>
            <th style="width: 20%">Material</th>
            <th>Unidade</th>
            <th>Q Obra Origem</th>
            <th>Q Obra Destino</th>
            <th>Q Transferida</th>
            <th>Saldo Obra Origem</th>
            <th>Saldo Obra Destino</th>
        </tr>
    </thead>
    <tbody> 

        @foreach ($result as $detalhes)
            <tr>
                <td>{{ $detalhes->codigo }}</td>
                <td>{{ $detalhes->descricao }}</td>
                <td>{{ $detalhes->codigo_mat }}</td>
                <td>{{ $detalhes->qtde_origem }}</td>
                <td>{{ $detalhes->qtde_destino }}</td>
                <td>{{ $detalhes->qtde_transf }}</td>
                <td>{{ $detalhes->qtde_origem - $detalhes->qtde_transf }}</td>
                <td>{{ $detalhes->qtde_destino +  $detalhes->qtde_transf }}</td>
            </tr>
        @endforeach

    </tbody>
</table>

@include('layouts.partials.footer_pdf')
</div>
</html>