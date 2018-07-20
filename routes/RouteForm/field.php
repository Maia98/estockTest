<?php

Route::group(['prefix' => 'field', 'namespace' => 'FormList'], function () {
        
        Route::get('/{form}', 'FieldController@index')->name('field');
        
        Route::get('/create', 'FieldController@create')->name('create');
        Route::post('/store', 'FieldController@store')->name('store');
        /*Route::get('/edit/{form}', 'FormController@edit')->name('edit');
        //Route::post('/update', 'ListController@update')->name('update');
        Route::get('/delete/{form}', 'FormController@delete')->name('delete');
        Route::post('/destroy', 'FormController@destroy')->name('destroy');*/
    });

?>    