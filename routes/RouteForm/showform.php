<?php

Route::group(['prefix' => 'showform', 'namespace' => 'FormList'], function () {
        
        Route::get('/', 'ShowFormController@index')->name('showform');
        Route::get('/show/{id}', 'ShowFormController@show')->name('show');
        Route::get('/create/{id}', 'ShowFormController@create')->name('create');
        Route::post('/store', 'ShowFormController@store')->name('store');
        Route::post('/update', 'ShowFormController@update')->name('update');
        //Route::get('/showForm/{id}', 'ShowFormController@showForm')->name('showForm');
        Route::get('/edit/{id}/{form_id}', 'ShowFormController@edit')->name('editFormData');
        Route::get('/delete/{id}/{form_id}', 'ShowFormController@delete')->name('deleteFormData');
        Route::post('/destroy', 'ShowFormController@destroy')->name('destroy');

    });

?>    