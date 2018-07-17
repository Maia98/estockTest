<html>
<div>
@include('layouts.partials.header_pdf')

    <table class="table">
        <tr>
            <th>Id</th>
            <th>Nome</th>
        </tr>
        @foreach($result as $row)
        <tr>
            <td width="20px">{{ $row->id }}</td>
            <td>{{ $row->nome }}</td>
        </tr>
        @endforeach
    </table>

@include('layouts.partials.footer_pdf')
</div>
</html>