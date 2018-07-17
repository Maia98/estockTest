<?php 
    
    Route::group(['prefix' => 'transferencia-estoque'], function () {

        Route::get('/', function () {
            return redirect('/transferencia-estoque/gerenciador');
        });
        
        Route::get('/create', 'TransferenciaEstoqueController@create');

        Route::get('/pesquisar-material', 'TransferenciaEstoqueController@pesquisarMaterial');

        Route::get('/gerenciador', 'TransferenciaEstoqueController@gerenciador');

        Route::get('/gerenciador/exportar-excel', 'TransferenciaEstoqueController@exportarExcel');

        Route::get('/gerenciador/exportar-pdf', 'TransferenciaEstoqueController@exportarPdf');

        Route::get('/detalhes/exportar-excel/{id}', 'TransferenciaEstoqueController@exportarDetalhesExcel');

        Route::get('/detalhes/exportar-pdf/{id}', 'TransferenciaEstoqueController@exportarDetalhesPdf');

        Route::get('/detalhes/{id}', 'TransferenciaEstoqueController@details');

        Route::get('/selecionar-estoque', function() {
            return redirect()->action('TransferenciaEstoqueController@create');
        });

        Route::post('/obras-origem', 'TransferenciaEstoqueController@obrasOrigem');

        Route::post('/obras-destino', 'TransferenciaEstoqueController@obrasDestino');

        Route::post('/selecionar-estoque', 'TransferenciaEstoqueController@selecionarEstoque');

        Route::post('/selecionar-material', 'TransferenciaEstoqueController@selecionarMaterial');

        Route::post('/save', 'TransferenciaEstoqueController@store');

    });
    
