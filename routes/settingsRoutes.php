<?php

Route::group(['prefix' => 'settings','middleware' => 'userAuth'], function(){

	Route::get('setup',[
		'as' => 'settings.setup',
		'uses' => 'SettingsController@setup'
	]);

	Route::get('add-designation',[
		'as' => 'settings.add-designation',
		'uses' => 'SettingsController@addDesignation'
	]);

	Route::get('view-designation',[
		'as' => 'settings.view-designation',
		'uses' => 'SettingsController@viewDesignation'
	]);

	Route::post('save-designation',[
		'as' => 'settings.save-designation.post',
		'uses' => 'SettingsController@saveDesignation'
	]);

	// Route::get('update-designation-status/{action}/{designationId}', [
 //        'as' => 'settings.update-designation-status',
 //        'uses' => 'SettingsController@updateDesignationStatus'
 //    ]);

    Route::get('update-save-designation',[
		'as' => 'settings.update-save-designation',
		'uses' => 'SettingsController@updateSaveDesignation'
	]);

    Route::get('update-status/{modelReference}/{action}/{id}', [
        'as' => 'settings.update-status',
        'uses' => 'SettingsController@updateStatus'
    ]);

	//Department
	Route::get('add-department',[
		'as' => 'settings.add-department',
		'uses' => 'SettingsController@addDepartment'
	]);

	Route::get('view-department',[
		'as' => 'settings.view-department',
		'uses' => 'SettingsController@viewDepartment'
	]);

	Route::post('save-department',[
		'as' => 'settings.save-department.post',
		'uses' => 'SettingsController@saveDepartment'
	]);

    Route::get('update-save-department',[
		'as' => 'settings.update-save-department',
		'uses' => 'SettingsController@updateSaveDepartment'
	]);

	//Educational Qualification
	Route::get('add-educational-qualification',[
		'as' => 'settings.add-educational-qualification',
		'uses' => 'SettingsController@addEducationalQualification'
	]);

	Route::get('view-educational-qualification',[
		'as' => 'settings.view-educational-qualification',
		'uses' => 'SettingsController@viewEducationalQualification'
	]);

	Route::post('save-educational-qualification',[
		'as' => 'settings.save-educational-qualification.post',
		'uses' => 'SettingsController@saveEducationalQualification'
	]);

    Route::get('update-save-educational-qualification',[
		'as' => 'settings.update-save-educational-qualification',
		'uses' => 'SettingsController@updateSaveEducationalQualification'
	]);

	//Medical Degree
	Route::get('add-medical-degree',[
		'as' => 'settings.add-medical-degree',
		'uses' => 'SettingsController@addMedicalDegree'
	]);

	Route::get('view-medical-degree',[
		'as' => 'settings.view-medical-degree',
		'uses' => 'SettingsController@viewMedicalDegree'
	]);

	Route::post('save-medical-degree',[
		'as' => 'settings.save-medical-degree.post',
		'uses' => 'SettingsController@saveMedicalDegree'
	]);

    Route::get('update-save-medical-degree',[
		'as' => 'settings.update-save-medical-degree',
		'uses' => 'SettingsController@updateSaveMedicalDegree'
	]);

	//Service Category
	Route::get('add-service-category',[
		'as' => 'settings.add-service-category',
		'uses' => 'SettingsController@addServiceCategory'
	]);

	Route::get('view-service-category',[
		'as' => 'settings.view-service-category',
		'uses' => 'SettingsController@viewServiceCategory'
	]);

	Route::post('save-service-category',[
		'as' => 'settings.save-service-category.post',
		'uses' => 'SettingsController@saveServiceCategory'
	]);

    Route::get('update-save-service-category',[
		'as' => 'settings.update-save-service-category',
		'uses' => 'SettingsController@updateSaveServiceCategory'
	]);

	//Service Sub Category
	Route::get('add-service-sub-category',[
		'as' => 'settings.add-service-sub-category',
		'uses' => 'SettingsController@addServiceSubCategory'
	]);

	Route::get('view-service-sub-category',[
		'as' => 'settings.view-service-sub-category',
		'uses' => 'SettingsController@viewServiceSubCategory'
	]);

	Route::post('save-service-sub-category',[
		'as' => 'settings.save-service-sub-category.post',
		'uses' => 'SettingsController@saveServiceSubCategory'
	]);

    Route::get('update-save-service-sub-category',[
		'as' => 'settings.update-save-service-sub-category',
		'uses' => 'SettingsController@updateSaveServiceSubCategory'
	]);

});