<?php 
    
    Route::group(['prefix' => 'entrada-estoque'], function () {
        
        Route::get('/', 'EntradaEstoqueController@gerenciador');

        Route::get('/gerenciador', 'EntradaEstoqueController@gerenciador');

        Route::get('/create', 'EntradaEstoqueController@create');

        Route::get('/gerenciador/exportar-excel', 'EntradaEstoqueController@exportarExcel');

        Route::get('/gerenciador/exportar-pdf', 'EntradaEstoqueController@exportarPdf');

         Route::get('/lista/exportar-excel', 'ListaEntradaMateriaisController@exportarExcel');

        Route::get('/lista/exportar-pdf', 'ListaEntradaMateriaisController@exportarPdf');

        Route::post('/store', 'EntradaEstoqueController@store');

        Route::post('/store-varias-obras', 'EntradaEstoqueController@storeVariasObras');

        Route::get('/add-obs/{id}', 'ListaEntradaMateriaisController@addObs');

        Route::get('/lista', 'ListaEntradaMateriaisController@index');

        Route::post('/conferir-entrada', 'EntradaEstoqueController@conferirEntradaEstoque');

        Route::get('/edit/{entradaEstoque}', 'EntradaEstoqueController@edit');

        Route::get('/delete/{entradaEstoque}', 'EntradaEstoqueController@delete');

        Route::post('/manual', 'EntradaEstoqueController@manual');

        Route::post('/destroy', 'EntradaEstoqueController@destroy');

        Route::post('/obter-unidade-medida', 'EntradaEstoqueController@obterUnidadeMedida');

        Route::post('/store-obs/', 'ListaEntradaMateriaisController@storeObs');

    });
    
