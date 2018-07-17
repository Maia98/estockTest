<?php 
    
    Route::group(['prefix' => 'tipo-entrada'], function () {
        
        Route::get('/', 'TipoEntradaController@index');

        Route::get('/create', 'TipoEntradaController@create');

        Route::get('/exportar-excel', 'TipoEntradaController@exportarExcel');

        Route::post('/store', 'TipoEntradaController@store');

        Route::get('/edit/{tipoEntrada}', 'TipoEntradaController@edit');

        Route::get('/delete/{tipoEntrada}', 'TipoEntradaController@delete');

        Route::post('/destroy', 'TipoEntradaController@destroy');
    });
    
    