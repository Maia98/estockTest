<?php 
    
    Route::group(['prefix' => 'saida-estoque'], function () {

        Route::get('/', 'SaidaEstoqueController@gerenciador');

        Route::get('/gerenciador', 'SaidaEstoqueController@gerenciador');
        
        Route::get('/create', 'SaidaEstoqueController@create');

        Route::get('/gerenciador/exportar-excel', 'SaidaEstoqueController@exportarExcel');

        Route::get('/gerenciador/exportar-pdf', 'SaidaEstoqueController@exportarPdf');

        Route::get('/lista/exportar-excel', 'ListaSaidaMateriaisController@exportarExcel');

        Route::get('/lista/exportar-pdf', 'ListaSaidaMateriaisController@exportarPdf');

        Route::post('/store', 'SaidaEstoqueController@store');

        Route::post('/store-varias-obras', 'SaidaEstoqueController@storeVariasObras');

        Route::get('/lista', 'ListaSaidaMateriaisController@index');

        Route::get('/add-obs/{id}', 'ListaSaidaMateriaisController@addObs');

        Route::post('/conferir-saida', 'SaidaEstoqueController@conferirSaidaEstoque');

        Route::get('/edit/{saidaEstoque}', 'SaidaEstoqueController@edit');

        Route::get('/delete/{saidaEstoque}', 'SaidaEstoqueController@delete');

        Route::post('/manual', 'SaidaEstoqueController@manual');

        Route::post('/destroy', 'SaidaEstoqueController@destroy');

        Route::post('/obter-unidade-medida', 'SaidaEstoqueController@obterUnidadeMedida');

        Route::post('/almoxarifado/{idObra}', 'SaidaEstoqueController@almoxarifado');

        Route::post('/almoxarifado-all/', 'SaidaEstoqueController@almoxarifadoAll');

        Route::post('/store-obs/', 'ListaSaidaMateriaisController@storeObs');


    });
    
