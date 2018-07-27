<?php

Route::group(['prefix' => 'showform', 'namespace' => 'FormList'], function () {
        
        Route::get('/', 'ShowFormController@index')->name('showform');
        Route::get('/show/{id}', 'ShowFormController@show')->name('show');
        /*Route::get('/create', 'FormController@create')->name('create');
        Route::post('/store', 'FormController@store')->name('store');
        Route::get('/edit/{form}', 'FormController@edit')->name('edit');
        //Route::post('/update', 'ListController@update')->name('update');
        Route::get('/delete/{form}', 'FormController@delete')->name('delete');
        Route::post('/destroy', 'FormController@destroy')->name('destroy');*/

    });

?>    