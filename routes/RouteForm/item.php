<?php
/**
 * Created by PhpStorm.
 * User: Wellington Maia
 * Date: 28/06/2018
 * Time: 07:15
 */


Route::group(['prefix' => 'item', 'namespace' => 'FormList'], function () {

    Route::get('/create', 'ItemController@create')->name('item');
    //Route::get('/create', 'ListController@create')->name('create');
    Route::post('/store', 'ItemController@store')->name('store');
    Route::get('/show/{id}', 'ItemController@show')->name('show');
    Route::get('/edit/{id}', 'ItemController@edit')->name('edit');
    Route::get('/delete/{id}', 'ItemController@delete')->name('delete');
    Route::post('/destroy', 'ItemController@destroy')->name('destroy');
});



?>