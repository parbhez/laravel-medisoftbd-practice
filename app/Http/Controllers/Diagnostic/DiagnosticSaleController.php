<?php

namespace App\Http\Controllers\Diagnostic;

use App\Models\Diagnostic\DiagnosticTest;
use App\Models\Diagnostic\ServiceGroup;
use App\Models\Diagnostic\ServicePackage;
use App\Models\Settings\ServiceCategory;
use App\Models\Settings\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Models\Outdoor\Patient;
use DB;
use Helper;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;

class DiagnosticSaleController extends Controller
{
    public function search(Request $request)
    {
        // Session::forget('patientInfo');
        $result = [];
        if($request->input('saleType') == 1){
            $result = DiagnosticTest::where('diagnostic_test_name', 'LIKE', "%{$request->input('q')}%")
                ->get([
                    'diagnostic_tests.diagnostic_test_name as service_name',
                    'diagnostic_tests.diagnostic_test_id as service_id',
                ]);
        }else if($request->input('saleType') == 2){
            $result = ServiceGroup::where('service_group_name', 'LIKE', "%{$request->input('q')}%")
                ->get([
                    'service_groups.service_group_name as service_name',
                    'service_groups.service_group_id as service_id',
                ]);
        }else if($request->input('saleType') == 3){
            $result = ServicePackage::where('service_package_name', 'LIKE', "%{$request->input('q')}%")
                ->get([
                    'service_packages.service_package_name as service_name',
                    'service_packages.service_package_id as service_id',
                ]);
        }
        return response()->json($result);
    }

    public function searchPatientForSale(Request $request)
    {
        // return $request->all();
        $result = [];
        $result = Patient::join('users','patients.user_id','=','users.user_id')
            ->where('users.full_name', 'LIKE', "%{$request->input('patient_name')}%")
            ->get([
                'users.full_name as patient_name',
                'users.user_id',
                'patients.patient_id'
            ]);
            
        return response()->json($result);
    }

    public function addPatientToSale($patientId)
    {
        $patient = Patient::join('users','patients.user_id','=','users.user_id')
            ->where('patients.patient_id', $patientId)
            ->first([
                'users.full_name as patient_name',
                'users.*',
                'patients.patient_id'
            ]);
            
        Session::put('patientInfo.patient_name',$patient->patient_name);
        Session::put('patientInfo.patient_contact',$patient->mobile_no);
        Session::put('patientInfo.patient_address',$patient->present_address);
        Session::put('patientInfo.email',$patient->email);
        Session::put('patientInfo.user_id',$patient->user_id);
        Session::put('patientInfo.patient_id',$patient->patient_id);
        return redirect()->route('diagnostic.sale-diagnotic-test');
    }
    public function removePatientFromSale()
    {
        Session::forget('patientInfo');
        return redirect()->route('diagnostic.sale-diagnotic-test');
    }

    public function addServiceToSale($saleType,$dtid)
    {
        $services = [];
        if($saleType == 3){
            $package = ServicePackage::where('service_package_id',$dtid)
                ->select([
                    'service_packages.service_package_name',
                    'service_packages.service_package_id',
                ])
                ->first();
            foreach($package->servicePackageItems as $servicePackage){
                if($servicePackage->type == 2){
                    $packageGroup = ServiceGroup::where('service_group_id',$servicePackage->service_item_id)
                        ->first();
                    $serviceInfo = [];
                    $testsArray = [];
                    foreach($packageGroup->serviceGroupItem as $diagnosticTestInfo){
                        // $testsArray[] = $diagnosticTestInfo->service;
                        $serviceInfo['diagnostic_test_id'] = $diagnosticTestInfo->service->diagnostic_test_id;
                        $serviceInfo['diagnostic_test_name'] = $diagnosticTestInfo->service->diagnostic_test_name;
                        $serviceInfo['diagnostic_test_sale_price'] = $diagnosticTestInfo->service->diagnostic_test_sale_price;
                        $serviceInfo['quantity'] = 1.00;
                        $serviceInfo['discount'] = 0.00;
                        $serviceInfo['total'] = $serviceInfo['diagnostic_test_sale_price'] - $serviceInfo['discount'];
                        $serviceInfo['service_package_id'] = $package->service_package_id;
                        $serviceInfo['service_group_id'] = $package->service_package_id;
                        $testsArray[] = $serviceInfo;
                    }
                    $services[$package->service_package_id.'-'.$package->service_package_name][$packageGroup->service_group_id.'-'.$packageGroup->service_group_name] = $testsArray;
                }else{
                    $serviceInfo = [];
                    $diagnostic = DiagnosticTest::where('diagnostic_test_id',$servicePackage->service_item_id)
                        ->first();
                    $serviceInfo['diagnostic_test_id'] = $diagnostic->diagnostic_test_id;
                    $serviceInfo['diagnostic_test_name'] = $diagnostic->diagnostic_test_name;
                    $serviceInfo['diagnostic_test_sale_price'] = $diagnostic->diagnostic_test_sale_price;
                    $serviceInfo['quantity'] = 1.00;
                    $serviceInfo['discount'] = 0.00;
                    $serviceInfo['total'] = $serviceInfo['diagnostic_test_sale_price'] - $serviceInfo['discount'];
                    $serviceInfo['service_package_id'] = $package->service_package_id;
                    $serviceInfo['service_group_id'] = 0;
                    $services[$package->service_package_id.'-'.$package->service_package_name]['No-Group'] = $serviceInfo;
                }
            }
            Session::put('saleItems.'.('Package-'.$dtid),$services);
        }else if($saleType == 2){
            $group = ServiceGroup::where('service_group_id', $dtid)
                ->first();
            $testsArray = [];
            $serviceInfo = [];
            foreach($group->serviceGroupItem as $serviceGroupItem){
                $serviceInfo['diagnostic_test_id'] = $serviceGroupItem->service->diagnostic_test_id;
                $serviceInfo['diagnostic_test_name'] = $serviceGroupItem->service->diagnostic_test_name;
                $serviceInfo['diagnostic_test_sale_price'] = $serviceGroupItem->service->diagnostic_test_sale_price;
                $serviceInfo['quantity'] = 1.00;
                $serviceInfo['discount'] = 0.00;
                $serviceInfo['total'] = $serviceInfo['diagnostic_test_sale_price'] - $serviceInfo['discount'];
                $serviceInfo['service_package_id'] = 0;
                $serviceInfo['service_group_id'] = $group->service_group_id;
                $testsArray[] = $serviceInfo;
            }
            $services['No-Package'][$group->service_group_id.'-'.$group->service_group_name] = $testsArray;
            Session::put('saleItems.'.('Group-'.$dtid),$services);
        }else if($saleType == 1){
            $serviceInfo = [];
            $diagnostic = DiagnosticTest::where('diagnostic_test_id',$dtid)
                ->first();
            $duplicate = 0;
            if(Session::has('saleItems')){
                if(Session::has('saleItems.'.('Service-'.$dtid))){
                    // print "<pre>";
                    // print_r(Session::get('saleItems'));
                    // return;
                    $duplicate = 1;
                    $serviceInfo['diagnostic_test_id']   = $diagnostic->diagnostic_test_id;
                    $serviceInfo['diagnostic_test_name'] = $diagnostic->diagnostic_test_name;
                    $serviceInfo['diagnostic_test_sale_price'] = $diagnostic->diagnostic_test_sale_price;
                    $serviceInfo['quantity'] = Session::get('saleItems.'.$dtid)['No-Package']['No-Group']['quantity'] + 1.00;
                    $serviceInfo['discount'] = $serviceInfo['quantity'] * 0.00;
                    $serviceInfo['total'] = ($serviceInfo['diagnostic_test_sale_price'] * $serviceInfo['quantity']) - $serviceInfo['discount'];
                }else{
                    $serviceInfo['diagnostic_test_id'] = $diagnostic->diagnostic_test_id;
                    $serviceInfo['diagnostic_test_name'] = $diagnostic->diagnostic_test_name;
                    $serviceInfo['diagnostic_test_sale_price'] = $diagnostic->diagnostic_test_sale_price;
                    $serviceInfo['quantity'] = 1.00;
                    $serviceInfo['discount'] = 0.00;
                    $serviceInfo['service_package_id'] = 0;
                    $serviceInfo['service_group_id'] = 0;
                    $serviceInfo['total'] = $serviceInfo['diagnostic_test_sale_price'] - $serviceInfo['discount'];
                }
            }else{
                $serviceInfo['diagnostic_test_id'] = $diagnostic->diagnostic_test_id;
                $serviceInfo['diagnostic_test_name'] = $diagnostic->diagnostic_test_name;
                $serviceInfo['diagnostic_test_sale_price'] = $diagnostic->diagnostic_test_sale_price;
                $serviceInfo['quantity'] = 1.00;
                $serviceInfo['discount'] = 0.00;
                $serviceInfo['service_package_id'] = 0;
                $serviceInfo['service_group_id'] = 0;
                $serviceInfo['total'] = $serviceInfo['diagnostic_test_sale_price'] - $serviceInfo['discount'];
            }
            $services['No-Package']['No-Group'] = $serviceInfo;
            Session::put('saleItems.'.('Service-'.$dtid),$services);
            if($duplicate == 1){
                return response()->json(['duplicate' => true,'dtid' => $dtid]);
            }
        }

        return view('diagnostic.sale.addServiceForSale', compact('services'));
    }
    public function getNumOfRowsDelete($reference)
    {
        $serviceType = str_replace(['Package','Group','Service'], [3,2,1], explode('-',$reference)[0]);
        $numOfRows = 0;
        if($serviceType == 3){
            $package = ServicePackage::where('service_package_id',explode('-',$reference)[1])
                ->first();
            foreach($package->servicePackageItems as $servicePackage){
                if($servicePackage->type == 2){
                    $packageGroup = ServiceGroup::where('service_group_id',$servicePackage->service_item_id)
                        ->first();
                    foreach($packageGroup->serviceGroupItem as $diagnosticTestInfo){
                        $numOfRows += 1;
                    }
                }else{
                    $diagnostic = DiagnosticTest::where('diagnostic_test_id',$servicePackage->service_item_id)
                        ->first();
                    if($diagnostic){
                        $numOfRows += 1;
                    }
                }
            }
        }else if($serviceType == 2){
            $group = ServiceGroup::where('service_group_id', explode('-',$reference)[1])
                ->first();
            foreach($group->serviceGroupItem as $serviceGroupItem){
                $numOfRows += 1;
            }
        }
     
    }

    public function emptySaleCart()
    {
        Session::forget('saleItems');
        Session::flash('success','Cart Cleared');
        return redirect()->route('diagnostic.sale-diagnotic-test');
    }
    public function getSubCategories(Request $request)
    {
        $service_sub_categories = ServiceSubCategory::where('service_category_id', $request->id)->pluck('service_sub_category_name', 'service_sub_category_id');
        return response()->json($service_sub_categories->toArray());
    }

    public function removeServiceFromSale($serviceId)
    {
        Session::forget('saleItems.'.$serviceId);
        return response()->json();
    }

    public function addContent()
    {
        return view('diagnostic.test.addForm');
    }

    public function completeDiagnosticSale(Request $request)
    {
        // return $request->all();
        if(Session::has('saleItems')){
            $saleItems = Session::get('saleItems');
            $items = [];
            foreach($saleItems as $key => $packages){
                foreach($packages as $key2 => $groups){
                    foreach($groups as $key3 => $group){
                        if($key3 != 'No-Group'){
                            foreach($group as $key4 => $service){
                                $items[] = $service;
                            }
                        }else{
                            $items[] = $group;
                        }
                    }
                }
            }
        }

        $totalAmount = 0;
        $saleInvoiceId = date('ymdhis');
        $invoice = DB::table('sale_invoices')
            ->insertGetId([
                'sale_invoice_id'   => $saleInvoiceId,
                'cus_id'            => 1,
                'payment_type_id'   => 1,
                'date' => $request->invoice_date,
                'created_by'        => 14
            ]);

        if($invoice){
            foreach($items as $key => $saleItem){
                $saleItem = (object) $saleItem;
                $invoiceDetails = DB::table('sale_invoice_details')
                    ->insert([
                        'sale_invoice_id'    => $saleInvoiceId,
                        'package_id'         => $saleItem->service_package_id,
                        'group_id'           => $saleItem->service_group_id,
                        'diagnostic_test_id' => $saleItem->diagnostic_test_id,
                        'quantity' => $saleItem->quantity,
                        'discount' => $saleItem->discount,
                        'tax' => 0,
                        'amount' => $saleItem->total,
                        'created_by' => 14,
                    ]);
                $totalAmount += $saleItem->total;
            }

            $receiptInfo = [];

            $receiptInfo['invoice_id'] = $saleInvoiceId;
            $receiptInfo['discount'] = $request->discount_taka;
            $receiptInfo['total_amount'] = $totalAmount;
            $receiptInfo['pay'] = $request->pay;
            $receiptInfo['due'] = $totalAmount-$request->pay;
            $receiptInfo['pay_note'] = $request->pay_note;
            $receiptInfo['return'] = $receiptInfo['pay_note'] - $receiptInfo['pay'];
            $receiptInfo = (object) $receiptInfo;
            
            $updateInvoice = DB::table('sale_invoices')
                ->where('sale_id',$invoice)
                ->update([
                    'discount' => $request->discount_taka,
                    'amount' =>  $totalAmount,
                    'pay' =>  $request->pay,
                    'due' =>  ($totalAmount-$request->pay),
                    'pay_note' =>  $request->pay_note,
                    'created_by' =>  14,
                ]);
        }
        return view('diagnostic.sale.saleReceipt', compact('receiptInfo'));
        print " <pre> ";
        print_r($items);
        exit;
        return 'hi';
        return view('diagnostic.test.addForm');
    }

}
