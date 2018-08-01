<?php

Route::group(['prefix' => 'showform', 'namespace' => 'FormList'], function () {
        
        Route::get('/', 'ShowFormController@index')->name('showform');
        Route::get('/show/{id}', 'ShowFormController@show')->name('show');
<<<<<<< HEAD
        Route::get('/create/{id}', 'ShowFormController@create')->name('create');
        Route::post('/store', 'ShowFormController@store')->name('store');
        Route::post('/update', 'ShowFormController@update')->name('update');
        //Route::get('/showForm/{id}', 'ShowFormController@showForm')->name('showForm');
        Route::get('/edit/{id}/{form_id}', 'ShowFormController@edit')->name('editFormData');
        Route::get('/delete/{id}/{form_id}', 'ShowFormController@delete')->name('deleteFormData');
        Route::post('/destroy', 'ShowFormController@destroy')->name('destroy');
=======
        /*Route::get('/create', 'FormController@create')->name('create');
        Route::post('/store', 'FormController@store')->name('store');
        Route::get('/edit/{form}', 'FormController@edit')->name('edit');
        //Route::post('/update', 'ListController@update')->name('update');
        Route::get('/delete/{form}', 'FormController@delete')->name('delete');
        Route::post('/destroy', 'FormController@destroy')->name('destroy');*/
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409

    });

?>    