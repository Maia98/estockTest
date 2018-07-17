<?php 
    
    Route::group(['prefix' => 'regional'], function () {
        
        Route::get('/', 'RegionalController@index');

        Route::get('/create', 'RegionalController@create');

        // Route::get('/exportar-excel', 'RegionalController@exportarExcel');

        Route::post('/store', 'RegionalController@store');

        Route::get('/edit/{regional}', 'RegionalController@edit');

        Route::get('/delete/{regional}', 'RegionalController@delete');

        Route::post('/destroy', 'RegionalController@destroy');
    });
    
    