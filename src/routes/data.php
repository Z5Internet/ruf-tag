<?php

Route::group(['prefix' => 'data/tags'], function () {

	Route::post('/addBatch', 'darrenmerrett\ReactTag\App\Http\Controllers\routesController@addBatch');

	Route::post('/addTag', 'darrenmerrett\ReactTag\App\Http\Controllers\routesController@addTag');

	Route::get('/getBatchs', 'darrenmerrett\ReactTag\App\Http\Controllers\routesController@getBatchs');
	
});