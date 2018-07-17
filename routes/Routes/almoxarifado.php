<?php 
    
    Route::group(['prefix' => 'almoxarifado'], function () {
        
        Route::get('/', 'AlmoxarifadoController@index');

        Route::get('/create', 'AlmoxarifadoController@create');
        
        Route::get('/exportar-excel', 'AlmoxarifadoController@exportarExcel');

        Route::get('/exportar-pdf', 'AlmoxarifadoController@exportarPdf');

        Route::post('/store', 'AlmoxarifadoController@store');

        Route::get('/edit/{almoxarifado}', 'AlmoxarifadoController@edit');

        Route::get('/delete/{almoxarifado}', 'AlmoxarifadoController@delete');

        Route::post('/destroy', 'AlmoxarifadoController@destroy');
    });
    
    