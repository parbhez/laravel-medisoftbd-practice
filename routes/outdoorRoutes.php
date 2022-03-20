<?php

Route::group(['prefix' => 'outdoor', 'middleware' => 'userAuth'], function () {

    Route::get('index', [
        'as' => 'outdoor.index',
        'uses' => 'OutdoorController@index'
    ]);

    Route::get('update-status/{modelReference}/{action}/{id}', [
        'as' => 'outdoor.update-status',
        'uses' => 'SettingsController@updateStatus'
    ]);

    Route::get('patient', [
        'as' => 'outdoor.patient',
        'uses' => 'OutdoorController@patientList'
    ]);

    Route::get('add-patient', [
        'as' => 'outdoor.add-patient',
        'uses' => 'OutdoorController@addPatient'
    ]);

    Route::post('save-patient', [
        'as' => 'outdoor.save-patient.post',
        'uses' => 'OutdoorController@savePatientInfo'
    ]);

    Route::get('edit-patient/{patientId}', [
        'as' => 'outdoor.edit-patient',
        'uses' => 'OutdoorController@editPatient'
    ]);
});