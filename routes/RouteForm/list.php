<?php


	
	Route::group(['prefix' => 'list', 'namespace' => 'FormList'], function () {
        
        Route::get('/', 'ListController@index')->name('list');
        Route::get('/create', 'ListController@create')->name('create');
        Route::post('/store', 'ListController@store')->name('store');
        Route::get('/edit/{list}', 'ListController@edit')->name('edit');
        //Route::post('/update', 'ListController@update')->name('update');
        Route::get('/delete/{list}', 'ListController@delete')->name('delete');
        Route::post('/destroy', 'ListController@destroy')->name('destroy');
    });

	



?>