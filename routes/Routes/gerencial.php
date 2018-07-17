<?php

    Route::group(['prefix' => 'gerencial'], function () {
        
        Route::get('/', 'GerencialController@index');

    	Route::post('/obra-por-status', 'GerencialController@obraPorStatus');

    	Route::post('/obra-por-regional', 'GerencialController@obraPorRegional');
    	
    	Route::post('/obra-por-valor-orcado', 'GerencialController@obraPorValorOracado');
    	
    	Route::post('/store-filter-usuario', 'GerencialController@storeFilterUsuario');

    });


    