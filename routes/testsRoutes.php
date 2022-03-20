<?php

Route::group(['prefix' => 'tests','middleware' => 'userAuth'], function(){
	Route::get('index',[
		'as' => 'tests.index',
		'uses' => 'TestsController@index'
	]);
});