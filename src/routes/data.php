<?php

Route::group(['prefix' => 'data/tags'], function () {

	Route::post('/addBatch', 'z5internet\ReactTag\App\Http\Controllers\RoutesController@addBatch');

	Route::post('/addTag', 'z5internet\ReactTag\App\Http\Controllers\RoutesController@addTag');

	Route::get('/getBatchs', 'z5internet\ReactTag\App\Http\Controllers\RoutesController@getBatchs');
	
});