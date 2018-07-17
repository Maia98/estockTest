<?php 
    
    Route::group(['prefix' => 'apontamento-medicao'], function () {
        
        Route::get('/', 'ApontamentoMedicaoController@index');

        Route::get('/create', 'ApontamentoMedicaoController@create');

        Route::post('/store', 'ApontamentoMedicaoController@store');

        Route::get('/edit/{apontamentoMedicao}', 'ApontamentoMedicaoController@edit');

        Route::get('/delete/{apontamentoMedicao}', 'ApontamentoMedicaoController@delete');

        Route::post('/destroy', 'ApontamentoMedicaoController@destroy');
    });
    
    