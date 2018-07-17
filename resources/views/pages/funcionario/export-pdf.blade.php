<html>
<div>
@include('layouts.partials.header_pdf')

    <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 20px">#</th>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>Cpf</th>
                            <th>Supervisor</th>
                            <th>Fiscal</th>
                            <th>Encarregado</th>
                            <th>Conferente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->nome}}</td>
                            <td>{{ $row->sobrenome}}</td>
                            <td>{{ $row->cpf}}</td>
                            <td> <center>{!! Form::checkbox('supervisor', ' ',$row->supervisor, ['disabled' => true]) !!} </center></td>
                            <td> <center>{!! Form::checkbox('fiscal', ' ',$row->fiscal, ['disabled' => true]) !!}</center></td>
                            <td> <center> {!! Form::checkbox('encarregado', ' ',$row->encarregado, ['disabled' => true]) !!} </center></td>
                            <td> <center> {!! Form::checkbox('conferente', ' ',$row->conferente, ['disabled' => true]) !!} </center></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

@include('layouts.partials.footer_pdf')
</div>
</html>