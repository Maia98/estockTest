<?php 
    
    Route::group(['prefix' => 'cidade'], function () {
        
        Route::get('/', 'CidadeController@index');

        Route::get('/create', 'CidadeController@create');

        Route::get('/exportar-excel', 'CidadeController@exportarExcel');

        Route::post('/store', 'CidadeController@store');

        Route::get('/edit/{cidade}', 'CidadeController@edit');

        Route::get('/delete/{cidade}', 'CidadeController@delete');

        Route::post('/destroy', 'CidadeController@destroy');

        Route::get('/get-cidade', 'CidadeController@getCidade');
    });
    
    