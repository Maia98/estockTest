<?php 

    Route::group(['prefix' => 'estoque'], function () {
        
        Route::get('/', 'EstoqueController@index');

        Route::get('/create', 'EstoqueController@create');
        
        Route::get('/exportar-excel', 'EstoqueController@exportarExcel');

        Route::get('/exportar-pdf', 'EstoqueController@exportarPdf');

        Route::get('/pesquisa', 'PesquisaEstoqueController@index');

        Route::get('/pesquisa/exportar-excel', 'PesquisaEstoqueController@exportarExcel');

        Route::get('/pesquisa/exportar-pdf', 'PesquisaEstoqueController@exportarPdf');

        Route::post('/store', 'EstoqueController@store');

        Route::get('/show', 'EstoqueController@show');

        Route::post('/destroy', 'EstoqueController@destroy');

        Route::get('/getAlmoxarifado', 'EstoqueController@getAlmoxarifado');
    });
    
    