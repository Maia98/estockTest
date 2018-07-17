<?php 
    
    Route::group(['prefix' => 'medicao'], function () {
        
        Route::get('/', 'MedicaoController@index');

        Route::get('/gerenciador', 'MedicaoController@index');

        Route::get('/create', 'MedicaoController@create');

        Route::get('/detalhes/exportar-excel/{id}', 'MedicaoController@exportarDetalhesExcel');

        Route::get('/detalhes/exportar-pdf/{id}', 'MedicaoController@exportarDetalhesPdf');

        Route::get('/exportar-excel', 'MedicaoController@exportarExcel');

        Route::get('/exportar-pdf', 'MedicaoController@exportarPdf');

        Route::post('/store', 'MedicaoController@store');

        Route::get('/edit/{tipoStatusMedicao}', 'MedicaoController@edit');

        Route::get('/delete/{tipoStatusMedicao}', 'MedicaoController@delete');

        Route::get('/detalhe-medicao/{id}', 'MedicaoController@show');

        Route::post('/destroy', 'MedicaoController@destroy');

        Route::get('/busca-dados', 'MedicaoController@sourceDados');

        Route::get('/create-valor-us/', 'ValorUSController@create');

        Route::post('/store-valor-us/', 'ValorUSController@store');

        Route::get('/create-valor-pago/{id}', 'MedicaoController@createValorPago');

        Route::post('/store-valor-pago', 'MedicaoController@storeValorPago');

    });
    
    