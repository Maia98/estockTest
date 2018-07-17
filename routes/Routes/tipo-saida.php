<?php 
    
    Route::group(['prefix' => 'tipo-saida'], function () {
        
        Route::get('/', 'TipoSaidaController@index');

        Route::get('/create', 'TipoSaidaController@create');

        Route::get('/exportar-excel', 'TipoSaidaController@exportarExcel');

        Route::post('/store', 'TipoSaidaController@store');

        Route::get('/edit/{tipoSaida}', 'TipoSaidaController@edit');

        Route::get('/delete/{tipoSaida}', 'TipoSaidaController@delete');

        Route::post('/destroy', 'TipoSaidaController@destroy');
    });
    
    