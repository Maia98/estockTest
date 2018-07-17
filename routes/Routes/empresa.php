<?php 
    
    Route::group(['prefix' => 'empresa'], function () {
        
        Route::get('/', 'EmpresaController@index');

        Route::get('/create', 'EmpresaController@create');
        
        Route::get('/exportar-excel', 'EmpresaController@exportarExcel');

        Route::get('/exportar-pdf', 'EmpresaController@exportarPdf');

        Route::post('/store', 'EmpresaController@store');

        Route::get('/edit/{empresa}', 'EmpresaController@edit');

        Route::get('/delete/{empresa}', 'EmpresaController@delete');

        Route::post('/destroy', 'EmpresaController@destroy');
    });
    
    