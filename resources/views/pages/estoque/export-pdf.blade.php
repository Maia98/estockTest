<html>
<title>{{ $name or "Export-pdf" }}</title>
<div>
@include('layouts.partials.header_pdf')

    <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Material</th>
                            <th>Qtde.</th>
                            <th>Unidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $row)
                        <tr>
                            <td>{{ $row->codigo }}</td>
                            <td>{{ $row->nomeMaterial }}</td>
                            <td>{{ $row->quantidade }}</td>
                            <td>{{ $row->codigo_unidade }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

@include('layouts.partials.footer_pdf')
</div>
</html>