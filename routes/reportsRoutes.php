<?php

Route::group(['prefix' => 'reports', 'middleware' => 'userAuth'], function(){
	Route::get('index',[
		'as' => 'reports.index',
		'uses' => 'ReportsController@index'
	]);

	Route::get('diagnostic-test-report',[
		'as' => 'reports.diagnostic-test-report',
		'uses' => 'ReportsController@diagnosticTestReport'
	]);

	Route::get('get-diagnostic-test-sale-report/{from}/{to}',[
		'as' => 'reports.getDiagnosticTestSaleReport',
		'uses' => 'ReportsController@getDiagnosticTestSaleReport'
	]);
	Route::post('get-diagnostic-test-sale-report-post',[
		'as' => 'reports.getDiagnosticTestSaleReport.post',
		'uses' => 'ReportsController@diagnosticTestReport'
	]);
	Route::get('sale-report-details/{saleInvoiceId}',[
		'as' => 'reports.getDiagnosticTestSaleReportDetails',
		'uses' => 'ReportsController@diagnosticTestSaleReportDetails'
	]);
});