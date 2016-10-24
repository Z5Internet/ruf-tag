<?php

Route::group(['prefix' => 'data/tags'], function () {

	Route::post('/addBatch', 'darrenmerrett\ReactTag\App\Http\Controllers\RoutesController@addBatch');

	Route::post('/addTag', 'darrenmerrett\ReactTag\App\Http\Controllers\RoutesController@addTag');

	Route::get('/getBatchs', 'darrenmerrett\ReactTag\App\Http\Controllers\RoutesController@getBatchs');
	
});