<?php 
    
Route::group(['prefix' => 'permissoes'], function () {
    
    Route::get('/', 'PermissoesController@index');

    Route::get('/create', 'PermissoesController@create');

    Route::post('/store', 'PermissoesController@store');

    Route::get('/edit/{permissao}', 'PermissoesController@edit');

    Route::post('/destroy', 'PermissoesController@destroy');
});