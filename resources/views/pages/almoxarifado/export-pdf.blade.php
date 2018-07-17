<html>
<div>
@include('layouts.partials.header_pdf')

     <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Nome</th>
                            <th>descricao</th>
                            <th><center>Cidade</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->nome }}</td>
                            <td>{{ $row->descricao }}</td>
                            <td>{{ $row->cidade }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

@include('layouts.partials.footer_pdf')
</div>
</html>