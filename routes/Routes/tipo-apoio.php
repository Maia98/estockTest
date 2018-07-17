<?php 
    
    Route::group(['prefix' => 'tipo-apoio'], function () {
        
        Route::get('/', 'TipoApoioController@index');

        Route::get('/create', 'TipoApoioController@create');
        
        // Route::get('/exportar-excel', 'TipoApoioController@exportarExcel');

        Route::post('/store', 'TipoApoioController@store');

        Route::get('/edit/{tipoApoio}', 'TipoApoioController@edit');

        Route::get('/delete/{tipoApoio}', 'TipoApoioController@delete');

        Route::post('/destroy', 'TipoApoioController@destroy');
    });
    
    