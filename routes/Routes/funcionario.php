<?php 
    
    Route::group(['prefix' => 'funcionario'], function () {
        
        Route::get('/', 'FuncionarioController@index');

        Route::get('/create', 'FuncionarioController@create');
        
        Route::get('/exportar-excel', 'FuncionarioController@exportarExcel');

        Route::get('/exportar-pdf', 'FuncionarioController@exportarPdf');

        Route::post('/store', 'FuncionarioController@store');

        Route::get('/edit/{funcionario}', 'FuncionarioController@edit');

        Route::get('/delete/{funcionario}', 'FuncionarioController@delete');

        Route::post('/destroy', 'FuncionarioController@destroy');
    });
    
    