<?php 

	Route::group(['prefix' => 'tipo-unidade-medida'], function(){

		Route::get('/', 'TipoUnidadeMedidaController@index');

		Route::get('/create', 'TipoUnidadeMedidaController@create');

		Route::post('/store', 'TipoUnidadeMedidaController@store');

		Route::get('/edit/{tipoUnidade}', 'TipoUnidadeMedidaController@edit');

		Route::get('/delete/{tipoUnidade}', 'TipoUnidadeMedidaController@delete');
		
		Route::post('/destroy', 'TipoUnidadeMedidaController@destroy');

	});