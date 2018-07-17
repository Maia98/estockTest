<?php 
    
    Route::group(['prefix' => 'tipo-status-medicao'], function () {
        
        Route::get('/', 'TipoStatusMedicaoController@index');

        Route::get('/create', 'TipoStatusMedicaoController@create');

        // Route::get('/exportar-excel', 'TipoStatusMedicaoController@exportarExcel');

        // Route::get('/exportar-pdf', 'TipoStatusMedicaoController@exportarPdf');

        Route::post('/store', 'TipoStatusMedicaoController@store');

        Route::get('/edit/{tipoStatusMedicao}', 'TipoStatusMedicaoController@edit');

        Route::get('/delete/{tipoStatusMedicao}', 'TipoStatusMedicaoController@delete');

        Route::post('/destroy', 'TipoStatusMedicaoController@destroy');

    });
    
    