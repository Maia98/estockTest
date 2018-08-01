
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
        Route::get('/field/{form?}', 'FieldController@index')->name('field');
        //Route::get('/filter', 'FieldController@filter');
        Route::get('/createField/{form}', 'FieldController@create')->name('createField');
        Route::post('/storeField', 'FieldController@store')->name('storeField');
        Route::get('/editField/{id}', 'FieldController@edit')->name('editField');
        Route::get('/deleteField/{id}', 'FieldController@delete')->name('deleteField');
        Route::post('/destroyField', 'FieldController@destroy')->name('destroyField');
        Route::get('/createFieldConfig/{id}', 'FieldController@createConfig')->name('configField');
        Route::post('/storeFieldConfig', 'FieldController@storeConfig')->name('storeConfig');

<<<<<<< HEAD
=======
=======
        Route::get('/field/{form}', 'FieldController@index')->name('field');
        Route::get('/createField/{form}', 'FieldController@create')->name('createField');
        Route::post('/storeField', 'FieldController@store')->name('storeField');
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    });

?>    