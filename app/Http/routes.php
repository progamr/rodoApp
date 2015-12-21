<?php

/**
index view route
*/

Route::get('/', function () {
    return view('index');
});

/**
 * API routes
 */
Route::group(['prefix' => 'todoApp/api'], function () {
    //todos post
    Route::post('/addTodo','todosController@store');
    Route::post('/editTodo','todosController@update');
    //todos get
    Route::get('/todos','todosController@index');
    Route::get('/todo/{id}','todosController@show');
    Route::get('/deleteTodo/{id}','todosController@delete');

});


