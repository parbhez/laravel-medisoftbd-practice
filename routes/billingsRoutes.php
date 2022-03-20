<?php

Route::group(['prefix' => 'billings','middleware' => 'userAuth'], function(){
	Route::get('index',[
		'as' => 'billings.index',
		'uses' => 'BillingsController@index'
	]);

	Route::get('update-status/{modelReference}/{action}/{id}', [
        'as' => 'billings.update-status',
        'uses' => 'BillingsController@updateStatus'
    ]);
});