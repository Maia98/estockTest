<html>
<title>{{ $name or "Export-pdf" }}</title>
<div>
@include('layouts.partials.header_pdf')

     <table class="table">
                    <thead>
                        <tr>
                            <th>Nº Obra</th>
                            <th>Status</th>
                            <th>Data Recebimento</th>
                            <th>Encarregado(s)</th>
                            <th>Regional</th>
                            <th>Cidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $row)

                        <tr>
                            <td>{{ $row->numero_obra }}</td>
                            <td>{{ $row->statusObra->nome}}</td>
                            <td><center>{{ dateToView($row->data_recebimento) }}</center></td>

                            <td>{{ $row->encarregados}}</td>
                            <td>{{ $row->cidade->regional->descricao}}</td>
                            <td>{{ $row->cidade->nome }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

@include('layouts.partials.footer_pdf')
</div>
</html>