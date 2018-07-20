
<?php
Route::group(['prefix' => 'form', 'namespace' => 'FormList'], function () {
        
        Route::get('/', 'FormController@index')->name('form');
        Route::get('/create', 'FormController@create')->name('create');
        Route::post('/store', 'FormController@store')->name('store');
        Route::get('/edit/{form}', 'FormController@edit')->name('edit');
        //Route::post('/update', 'ListController@update')->name('update');
        Route::get('/delete/{form}', 'FormController@delete')->name('delete');
        Route::post('/destroy', 'FormController@destroy')->name('destroy');
        
        //Campo
        Route::get('/field/{form}', 'FieldController@index')->name('field');
        Route::get('/createField/{form}', 'FieldController@create')->name('createField');
        Route::post('/storeField', 'FieldController@store')->name('storeField');
    });

?>    