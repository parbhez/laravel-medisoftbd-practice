<?php

Route::group(['prefix' => 'pharmacy','middleware' => 'userAuth'], function(){
	Route::get('index',[
		'as' => 'pharmacy.index',
		'uses' => 'PharmacyController@index'
	]);
});