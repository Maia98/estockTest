<?php 

    Route::group(['prefix' => 'materiais'], function () {
        
        Route::get('/', 'MateriaisController@index');

        Route::get('/create', 'MateriaisController@create');
        
        Route::get('/exportar-excel', 'MateriaisController@exportarExcel');

        Route::get('/exportar-pdf', 'MateriaisController@exportarPdf');

        Route::post('/store', 'MateriaisController@store');

        Route::get('/edit/{funcionario}', 'MateriaisController@edit');

        Route::get('/delete/{funcionario}', 'MateriaisController@delete');

        Route::get('/show/{id}', 'MateriaisController@show');

        Route::post('/destroy', 'MateriaisController@destroy');
    });
    
    