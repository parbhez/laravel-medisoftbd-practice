<?php

Route::group(['prefix' => 'diagnostic', 'middleware' => 'userAuth'], function () {

    Route::get('index', [
        'as' => 'diagnostic.index',
        'uses' => 'DiagnosticController@index'
    ]);

    Route::get('diagnostic-test', [
        'as' => 'diagnostic-test',
        'uses' => 'DiagnosticController@diagnosticTestList'
    ]);

    Route::get('add-diagnostic-test', [
        'as' => 'add-diagnostic-test',
        'uses' => 'DiagnosticController@addDiagnosticTest'
    ]);

    Route::get('add-diagnostic-test-new', [
        'as' => 'add-diagnostic-test-new',
        'uses' => 'DiagnosticController@addDiagnosticTestNew'
    ]);

    Route::get('add-diagnostic-service-group', [
        'as' => 'add-diagnostic-service-group',
        'uses' => 'DiagnosticController@addServiceGroup'
    ]);

    Route::get('add-diagnostic-service-package', [
        'as' => 'add-diagnostic-service-package',
        'uses' => 'DiagnosticController@addServicePackage'
    ]);


    Route::get('view-diagnostic-service-group', [
        'as' => 'view-diagnostic-service-group',
        'uses' => 'DiagnosticController@serviceGroupList'
    ]);

    Route::get('edit-service-group/{id}', [
        'as' => 'edit-service-group',
        'uses' => 'DiagnosticController@editServiceGroup'
    ]);

    Route::get('search_service', [
        'as' => 'search_service',
        'uses' => 'DiagnosticController@search'
    ]);

    

    Route::get('add-service', [
        'as' => 'add-service',
        'uses' => 'DiagnosticController@addService'
    ]);

    Route::post('update-serviceGroup.post', [
        'as' => 'update-serviceGroup.post',
        'uses' => 'DiagnosticController@updateServiceGroup'
    ]);

// Service Sale
    Route::get('search-service-for-sale', [
        'as' => 'diagnostic.search-service-for-sale',
        'uses' => 'DiagnosticSaleController@search'
    ]);

    Route::get('search-patient-for-sale', [
        'as' => 'diagnostic.search-patient-for-sale',
        'uses' => 'DiagnosticSaleController@searchPatientForSale'
    ]);

    Route::get('add-service-to-sale/{saleType}/{dtid}', [
        'as' => 'add-service-to-sale',
        'uses' => 'DiagnosticSaleController@addServiceToSale'
    ]);

    Route::get('add-patient-to-sale/{patientId}', [
        'as' => 'add-patient-to-sale',
        'uses' => 'DiagnosticSaleController@addPatientToSale'
    ]);
    Route::get('remove-patient-from-sale', [
        'as' => 'diagnostic.remove-patient-from-sale',
        'uses' => 'DiagnosticSaleController@removePatientFromSale'
    ]);

    Route::get('get-num-of-rows-delete/{reference}', [
        'as' => 'diagnostic.get-num-of-rows-delete',
        'uses' => 'DiagnosticSaleController@getNumOfRowsDelete'
    ]);
    Route::get('remove-service-from-sale/{id}', [
        'as' => 'diagnostic.remove-service-from-sale',
        'uses' => 'DiagnosticSaleController@removeServiceFromSale'
    ]);
    Route::get('empty-sale-cart', [
        'as' => 'diagnostic.empty-sale-cart',
        'uses' => 'DiagnosticSaleController@emptySaleCart'
    ]);

    Route::post('completeDiagnosticSale', [
        'as' => 'diagnostic.completeDiagnosticSale.post',
        'uses' => 'DiagnosticSaleController@completeDiagnosticSale'
    ]);

//Service Sale End

    Route::get('get-diagnostic-ssc', [
        'as' => 'get-diagnostic-ssc',
        'uses' => 'DiagnosticController@getSubCategories'
    ]);
    //Test New Content
    Route::get('add-content',[
        'as' => 'add-content',
        'uses' => 'DiagnosticController@addContent'
    ]);

    Route::post('save-diagnosticTest.post', [
        'as' => 'save-diagnosticTest.post',
        'uses' => 'DiagnosticController@saveDiagnosticTest'
    ]);

    Route::get('edit-diagnosticTest/{diagnosticTestId}', [
        'as' => 'edit-diagnosticTest',
        'uses' => 'DiagnosticController@editdiagnosticTest'
    ]);

    Route::post('update-diagnosticTest', [
        'as' => 'update-diagnosticTest.post',
        'uses' => 'DiagnosticController@updateDiagnosticTest'
    ]);

    Route::get('update-status/{modelReference}/{action}/{id}', [
        'as' => 'diagnostic.update-status',
        'uses' => 'DiagnosticController@updateStatus'
    ]);

    Route::get('getDiagnosticTest', [
        'as' => 'diagnostic.getDiagnosticTest.ajax',
        'uses' => 'DiagnosticController@getDiagnosticTestAjax'
    ]);

    Route::get('getServiceGroup', [
        'as' => 'diagnostic.getServiceGroup.ajax',
        'uses' => 'DiagnosticController@getServiceGroupAjax'
    ]);

    Route::post('save-serviceGroup.post', [
        'as' => 'save-serviceGroup.post',
        'uses' => 'DiagnosticController@saveServiceGroup'
    ]);

    Route::post('save-servicePackage.post', [
        'as' => 'save-servicePackage.post',
        'uses' => 'DiagnosticController@saveServicePackage'
    ]);

    //Sale Routes
     Route::get('sale-diagnotic-test', [
         'as' => 'diagnostic.sale-diagnotic-test',
         'uses' => 'DiagnosticController@saleFormDiagnoticTest'
     ]);

    Route::get('item-auto-suggest', [
        'as' => 'diagnostic.sale.itemAutoSuggest',
        'uses' => 'DiagnosticController@itemAutoSuggest'
    ]);
    Route::get('auto-customer-suggest', [
        'as' => 'diagnostic.sale.autoCustomerSuggest',
        'uses' => 'DiagnosticController@autoCustomerSuggest'
    ]);
    Route::post('add-invoice-to-queue', [
        'as' => 'diagnostic.sale.addInvoiceToQueue.post',
        'uses' => 'DiagnosticController@addInvoiceToQueue'
    ]);

    Route::post('reload-delete-invoice-queue-element', [
        'as' => 'diagnostic.sale.reloadDeleteInvoiceQueueElement',
        'uses' => 'DiagnosticController@reloadDeleteInvoiceQueueElement'
    ]);
    Route::get('empty-cart', [
        'as' => 'diagnostic.sale.emptyCart',
        'uses' => 'DiagnosticController@emptyCart'
    ]);
    Route::post('edit-delete-item', [
        'as' => 'diagnostic.sale.editDeleteItem',
        'uses' => 'DiagnosticController@editDeleteItem'
    ]);
    Route::post('add-item-to-chart', [
        'as' => 'diagnostic.sale.addItemToChart',
        'uses' => 'DiagnosticController@addItemToChart'
    ]);
    Route::post('select-delete-customer', [
        'as' => 'diagnostic.sale.selectDeleteCustomer',
        'uses' => 'DiagnosticController@selectDeleteCustomer'
    ]);
    Route::post('invoice-and-sale', [
        'as' => 'diagnostic.sale.invoiceAndSale',
        'uses' => 'DiagnosticController@invoiceAndSale'
    ]);
});
