<html>
<div>
@include('layouts.partials.header_pdf')

     <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Unidade</th>
                            <th>Peso</th>
                            <th>Valor</th>
                            <th>Qtde. Mínima</th>
                            <th>Qtde. Crítica</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>{{ $row->descricao }}</td>
                            <td>{{ $row->unidade }}</td>
                            <td>{{ $row->peso }}</td>
                            <td>{{ $row->valor }}</td>
                            <td>{{ $row->qtde_minima }}</td>
                            <td>{{ $row->qtde_critica }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

@include('layouts.partials.footer_pdf')
</div>
</html>