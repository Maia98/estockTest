<?php 
    
Route::group(['prefix' => 'usuarios'], function () {
    
    Route::get('/', 'UsuarioController@index');

    Route::get('/create', 'UsuarioController@create');

    Route::post('/store', 'UsuarioController@store');

    Route::get('/get-funcoes/{usuario}', 'UsuarioController@getFuncoes');

    Route::get('/edit/{usuario}', 'UsuarioController@edit');

    Route::post('/change/password', 'UsuarioController@changePassword');

    Route::get('/change/password', 'UsuarioController@createChangePass');
});