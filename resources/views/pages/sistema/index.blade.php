@extends('layouts.default')

@section('main-content')
<div id="box-pesquisar" class="box box-default color-palette-box" style="min-height: 85vh;">
 	<div class="box-header with-border">
    	<h3 class="box-title"><i class="fa fa-tag"></i> Tabelas do Sistema</h3>
  	</div>
  	<div class="box-body">
		
			<ul class="table-list">
				<li>
					<a href="{{ url('/sistema/almoxarifado') }}"><i class="fa fa-table"></i> Almoxarifado</a>
					<a href="{{ url('/sistema/apontamento-medicao') }}"><i class="fa fa-table"></i> Apontamento Medição</a>
					<a href="{{ url('/sistema/regional') }}"><i class="fa fa-table"></i> Cadastro Regional</a>
					<a href="{{ url('/sistema/cidade') }}"><i class="fa fa-table"></i> Cidade</a>
					<a href="{{ url('/sistema/funcionario') }}"><i class="fa fa-table"></i> Funcionário</a>
					<a href="{{ url('/sistema/funcoes') }}"><i class="fa fa-table"></i> Funções</a>
					<a href="{{ url('/sistema/status-obra') }}"><i class="fa fa-table"></i> Status Obra</a>
					<a href="{{ url('/sistema/tipo-apoio') }}"><i class="fa fa-table"></i> Tipo Apoio</a>
					<a href="{{ url('/sistema/tipo-entrada') }}"><i class="fa fa-table"></i> Tipo Entrada</a>
					<a href="{{ url('/sistema/tipo-material') }}"><i class="fa fa-table"></i> Tipo Material</a>
					<a href="{{ url('/sistema/tipo-obra') }}"><i class="fa fa-table"></i> Tipo Obra</a>
					<a href="{{ url('/sistema/tipo-prioridade') }}"><i class="fa fa-table"></i> Tipo Prioridade</a>
					<a href="{{ url('/sistema/tipo-saida') }}"><i class="fa fa-table"></i> Tipo Saída</a>
					<a href="{{ url('/sistema/tipo-setor-obra') }}"><i class="fa fa-table"></i> Tipo Setor Obra</a>
					<a href="{{ url('/sistema/tipo-status-medicao') }}"><i class="fa fa-table"></i> Tipo Status Medição</a>
					<a href="{{ url('/sistema/tipo-unidade-medida') }}"><i class="fa fa-table"></i> Tipo Unidade</a>

				</li>
			</ul>
		
  	</div>  
</div>
@endsection
