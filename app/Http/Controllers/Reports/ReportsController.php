<?php

namespace App\Http\Controllers\Reports;
use App\Models\Diagnostic\DiagnosticTest;

use Illuminate\Http\Request;
use DB;
use Helper;
use Yajra\Datatables\Datatables;
use App\Models\Diagnostic\SaleInvoice;
use App\Models\Diagnostic\SaleInvoiceDetail;

class ReportsController extends Controller
{
    public function index()
    {
    	return view('reports.report');
    }

    public function diagnosticTestReport(Request $request)
    {
    	$from 	= date('Y-m-d');
		$to 	= date('Y-m-d');
		if($request->from && $request->to){
			$from = $request->from;
			$to = $request->to;
		}
    	return view('reports.diagnosticTest.diagnosticTestReport',compact('from','to'));
    }

    public function getDiagnosticTestSaleReport($from,$to)
    {
		
    	$model = SaleInvoice::orderBy('sale_invoice_id', 'ASC')
            ->whereBetween('date', [$from,$to]);
        return Datatables::of($model)
	        ->addColumn('invoice_id', function ($saleReport) {
                $html = '<a href="#saleReportModal" data-toggle="modal" class="btn btn-primary btn-sm" onclick="saleDetails('.$saleReport->sale_invoice_id.')">';
	            $html .= $saleReport->sale_invoice_id.'</a>';
	            return $html;
	            	
            })
            ->addColumn('total', function ($saleReport) {
                return $saleReport->amount;
	            	
            })
            ->addColumn('paid', function ($saleReport) {
                return $saleReport->pay;
	            	
            })
            ->editColumn('status', function ($saleReport) {
                $html = '';
                $html .= "<label class='label label-warning'";
                if ($saleReport->status == 1) {
                    $html .= "style='display:none'";
                }
                $html .= ">Processing</label>";

                $html .= "<label class='label label-success'";
                if ($saleReport->status == 0) {
                    $html .= "style='display:none'";
                }
                $html .= ">Completed</label>";
                return $html;
            })
            ->addColumn('action', function ($saleReport) {
                $html = '<a href="#" class="btn btn-xs btn-primary"> Edit </a>';
                return $html;
            })
            ->rawColumns(['invoice_id','total','paid','status', 'action'])
            ->make();
    	return view('reports.diagnosticTest.diagnosticTestReport');
    }

    public function diagnosticTestSaleReportDetails($saleInvoiceId)
    {

    	$invoiceInfo = SaleInvoice::where('sale_invoices.sale_invoice_id',$saleInvoiceId)
    		->first();
    	if($invoiceInfo){
			$invoiceDetails = SaleInvoiceDetail::where('sale_invoice_id',$invoiceInfo->sale_invoice_id)
	    		->get();
	    	$patientInfo = DB::table('patients')
	    		->join('users','patients.user_id','=','users.user_id')
	    		->where('patients.patient_id',$invoiceInfo->cus_id)
    			->first([
    				'users.*',
    				'patients.*',
    			]);
    	}


    	return view('reports.diagnosticTest.diagnosticTestReportReceipt',compact('invoiceInfo','invoiceDetails','patientInfo'));
    }
}
