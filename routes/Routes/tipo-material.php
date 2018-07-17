<?php 
    
    Route::group(['prefix' => 'tipo-material'], function () {
        
        Route::get('/', 'TipoMaterialController@index');

        Route::get('/create', 'TipoMaterialController@create');
        
        Route::get('/exportar-excel', 'TipoMaterialController@exportarExcel');

        Route::get('/exportar-pdf', 'TipoMaterialController@exportarPdf');

        Route::post('/store', 'TipoMaterialController@store');

        Route::get('/edit/{tipoMaterial}', 'TipoMaterialController@edit');

        Route::get('/delete/{tipoMaterial}', 'TipoMaterialController@delete');

        Route::post('/destroy', 'TipoMaterialController@destroy');
    });
    
    