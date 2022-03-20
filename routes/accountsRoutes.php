<?php

Route::group(['prefix' => 'accounts'], function(){

	Route::get('index',[
		'as' => 'accounts.index',
		'uses' => 'AccountsController@index'
	]);

});