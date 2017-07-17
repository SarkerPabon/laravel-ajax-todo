<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('todo', 'ListsController@index');
Route::get('search', 'ListsController@search');
Route::post('todo', 'ListsController@create');
Route::post('update', 'ListsController@update');
Route::post('delete', 'ListsController@delete');

/*Route::get('todo', function () {
    return view('list');
});*/
