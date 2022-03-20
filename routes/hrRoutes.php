<?php

Route::group(['prefix' => 'hr', 'middleware' => 'userAuth'], function () {
    Route::get('index', [
        'as' => 'hr.index',
        'uses' => 'HRController@index'
    ]);

    Route::group(['middleware' => 'hr-middleware'], function () {
        
        Route::get('employee', [
            'as' => 'hr.employee',
            'uses' => 'HRController@employeeList'
        ]);

        // Route::get('add-employee', [
        //     'as' => 'hr.add-employee',
        //     'uses' => 'HRController@addEmployee'
        // ]);
        
        Route::post('save-employee', [
            'as' => 'hr.save-employee.post',
            'uses' => 'HRController@saveEmployeeInfo'

        ]);
        Route::get('edit-employee/{employeeId}', [
            'as' => 'hr.edit-employee',
            'uses' => 'HRController@editEmployee'
        ]);
        Route::post('update-save-employee/{employeeId}', [
            'as' => 'hr.update-save-employee.post',
            'uses' => 'HRController@updateSaveEmployeeInfo'
        ]);

        Route::get('update-employee-status/{action}/{userId}', [
            'as' => 'hr.update-employee-status',
            'uses' => 'HRController@updateEmployeeStatus'
        ]);

        Route::get('add-doctor', [
            'as' => 'hr.add-doctor',
            'uses' => 'HRController@addDoctor'
        ]);

        Route::post('save-doctor', [
            'as' => 'hr.save-doctor.post',
            'uses' => 'HRController@saveDoctorInfo'
        ]);

        Route::post('update-doctor', [
            'as' => 'hr.update-doctor.post',
            'uses' => 'HRController@updateDoctorInfo'
        ]);

        Route::get('doctor', [
            'as' => 'hr.doctor',
            'uses' => 'HRController@doctorList'
        ]);

        Route::get('edit-doctor/{userId}', [
            'as' => 'hr.edit-doctor',
            'uses' => 'HRController@editDoctor'
        ]);

        Route::get('update-doctor-status/{action}/{userId}', [
            'as' => 'hr.update-doctor-status',
            'uses' => 'HRController@updateDoctorStatus'
        ]);

        Route::get('test', [
            'as' => 'hr.test',
            'uses' => 'HRController@test'
        ]);

        Route::get('schedule', [
            'as' => 'hr.schedule',
            'uses' => 'HRController@scheduleList'
        ]);

        Route::get('add-schedule', [
            'as' => 'hr.add-schedule',
            'uses' => 'HRController@addSchedule'
        ]);

        Route::post('save-schedule', [
            'as' => 'hr.save-schedule.post',
            'uses' => 'HRController@saveScheduleInfo'
        ]);

        Route::get('edit-schedule/{scheduleId}', [
            'as' => 'hr.edit-schedule',
            'uses' => 'HRController@editSchedule'
        ]);

        Route::post('update-schedule', [
            'as' => 'hr.update-schedule.post',
            'uses' => 'HRController@UpdateScheduleInfo'
        ]);

        Route::get('block-schedule', [
            'as' => 'hr.block-schedule',
            'uses' => 'HRController@blockSchedule'
        ]);

//        Route::post('get-appointment-schedule', [
//            'as' => 'hr.get-appointment-schedule.post',
//            'uses' => 'HRController@getAppointmentSchedule'
//        ]);


        Route::get('get-schedule', [
            'as' => 'hr.get-schedule',
            'uses' => 'HRController@getSchedule'
        ]);

        Route::get('update-schedule', [
            'as' => 'hr.update-schedule',
            'uses' => 'HRController@updateSchedule'
        ]);

        Route::get('update-schedule-status/{action}/{scheduleId}', [
            'as' => 'hr.update-schedule-status',
            'uses' => 'HRController@updateScheduleStatus'
        ]);

    });
});
