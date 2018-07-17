<html>
<title>{{ $name or "export_pdf" }}</title>
<div>
@include('layouts.partials.header_pdf')

     <table class="table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Usuário Sistema</th>
                            <th>Data Movimento</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $row)
                        <tr>
                            <td>{{ $row->status_obra }}</td>
                            <td>{{ $row->usuario->name }}</td>
                            <td>{{ date('d/m/Y H:i', strtotime($row->created_at)) }}</td>
                            <td>{{ $row->descricao }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

@include('layouts.partials.footer_pdf')
</div>
</html>