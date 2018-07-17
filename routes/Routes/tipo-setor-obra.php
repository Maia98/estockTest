<?php 
    
    Route::group(['prefix' => 'tipo-setor-obra'], function () {
        
        Route::get('/', 'TipoSetorObraController@index');

        Route::get('/create', 'TipoSetorObraController@create');

        // Route::get('/exportar-excel', 'TipoSetorObraController@exportarExcel');

        Route::post('/store', 'TipoSetorObraController@store');

        Route::get('/edit/{tipoSetorObra}', 'TipoSetorObraController@edit');

        Route::get('/delete/{tipoSetorObra}', 'TipoSetorObraController@delete');

        Route::post('/destroy', 'TipoSetorObraController@destroy');
    });
    
    