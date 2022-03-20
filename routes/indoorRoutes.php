<?php


Route::group(['prefix' => 'indoor', 'middleware' => 'userAuth'], function(){
	Route::get('index',[
		'as' => 'indoor.index',
		'uses' => 'IndoorController@index'
	]);
});