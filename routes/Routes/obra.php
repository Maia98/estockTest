<?php 
    
    Route::group(['prefix' => 'obra'], function () {

        Route::get('/', 'ObraController@index');
        
        Route::get('/gerenciador', 'ObraController@index');

        Route::get('/gerenciador/exportar-excel', 'ObraController@exportarExcel');

        Route::get('/gerenciador/exportar-pdf', 'ObraController@exportarPdf');

        Route::get('/documents-export/{id}', 'ObraController@documentsExport');

        Route::post('/store-documents', 'ObraController@storeDocuments');

        Route::post('/delete-documents', 'ObraController@deleteDocuments');

        Route::post('/download-documents', 'ObraController@downloadDocuments');

        Route::get('/create', 'ObraController@create');

        Route::get('/gerenciador/exportar-geral-excel', 'ObraController@exportarGeralExcel');

        Route::get('/gerenciador/exportar-listao-excel', 'ObraController@exportarListaoExcel');

        Route::get('/exportar-pdf', 'ObraController@exportarPdf');

        Route::post('/store', 'ObraController@store');

        Route::get('/edit/{obra}', 'ObraController@edit');

        Route::get('/delete/{obra}', 'ObraController@delete');

        Route::get('/details/{obra}', 'ObraController@showDetails');
        
        Route::post('/destroy', 'ObraController@destroy');
        
        Route::post('/conferir-material-orcado', 'ObraController@conferirMaterialOrçado');

        Route::get('/show-historico/{idObra}', 'RegistroHistoricoObraController@show'); 

        Route::get('/create-historico/{idObra}', 'RegistroHistoricoObraController@create');

        Route::post('/store-historico', 'RegistroHistoricoObraController@store');

        Route::get('/show-historico/exportar-excel/{idObra}', 'RegistroHistoricoObraController@exportarExcel');

        Route::get('/show-historico/exportar-pdf/{idObra}', 'RegistroHistoricoObraController@exportarPdf');

        Route::get('/show-balanco/{idObra}/{saldo}', 'BalancoMateriaisObraController@show');

        Route::get('/balanco/exportar-excel/{idObra}', 'BalancoMateriaisObraController@exportarExcel');

        Route::get('/balanco/exportar-pdf/{idObra}', 'BalancoMateriaisObraController@exportarPdf');

        Route::get('/imagens/{id}', 'ObraController@imagens');


    });
    
    