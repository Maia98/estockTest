<?php 
    
    Route::group(['prefix' => 'tipo-prioridade'], function () {
        
        Route::get('/', 'TipoPrioridadeController@index');

        Route::get('/create', 'TipoPrioridadeController@create');

        // Route::get('/exportar-excel', 'TipoPrioridadeController@exportarExcel');

        Route::post('/store', 'TipoPrioridadeController@store');

        Route::get('/edit/{tipoPrioridade}', 'TipoPrioridadeController@edit');

        Route::get('/delete/{tipoPrioridade}', 'TipoPrioridadeController@delete');

        Route::post('/destroy', 'TipoPrioridadeController@destroy');
    });
    
    