<?php 
    
    Route::group(['prefix' => 'tipo-obra'], function () {
        
        Route::get('/', 'TipoObraController@index');

        Route::get('/create', 'TipoObraController@create');

        Route::post('/store', 'TipoObraController@store');

        Route::get('/edit/{tipoObra}', 'TipoObraController@edit');

        Route::get('/delete/{tipoObra}', 'TipoObraController@delete');

        Route::post('/destroy', 'TipoObraController@destroy');

    });
    
    