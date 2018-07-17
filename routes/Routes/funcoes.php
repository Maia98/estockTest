<?php 
    
Route::group(['prefix' => 'funcoes'], function () {
    
    Route::get('/', 'FuncaoController@index');

    Route::get('/create', 'FuncaoController@create');

    Route::post('/store', 'FuncaoController@store');

    Route::get('/edit/{funcao}', 'FuncaoController@edit');

    Route::get('/delete/{funcao}', 'FuncaoController@delete');

    Route::get('/get-permissoes/{funcao}', 'FuncaoController@getPermissoes');

    Route::post('/destroy', 'FuncaoController@destroy');
});