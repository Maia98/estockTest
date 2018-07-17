<?php 
    
    Route::group(['prefix' => 'status-obra'], function () {
        
        Route::get('/', 'StatusObraController@index');

        Route::get('/create', 'StatusObraController@create');

        // Route::get('/exportar-excel', 'StatusObraController@exportarExcel');

        Route::post('/store', 'StatusObraController@store');

        Route::get('/edit/{statusObra}', 'StatusObraController@edit');

        Route::get('/delete/{statusObra}', 'StatusObraController@delete');

        Route::post('/destroy', 'StatusObraController@destroy');
    });
    
    