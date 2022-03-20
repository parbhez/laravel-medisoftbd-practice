

<style type="text/css">
	@media print{
		.print-btn{
			display: none;
		}
		footer{
			display: none;
		}
	}
</style>
<!-- Main content -->
<section class="content">
	<a href="#" class="btn btn-primary print-btn pull-right" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
    <!-- SELECT2 EXAMPLE -->
<!-- SELECT2 EXAMPLE -->
	<!-- title row -->
    <div class="row">
      <div class="col-md-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> Medisoft BD.
          <small class="pull-right">Date: {{$invoiceInfo->date}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
    	<div class="col-md-12">
	      <div class="col-sm-4 invoice-col">
	        From
	        <address>
	          <strong>Medisoft BD.</strong><br>
	          Baitussharf Masjid Complex<br>
	          Farmgate, Dhaka<br>
	          Phone: <br>
	          Email: info@domain.com
	        </address>
	      </div>
	      <!-- /.col -->
	      <div class="col-sm-4 invoice-col">
	        To
	        	@if($patientInfo)
			        <address>
			          <strong>{{$patientInfo->full_name')}}</strong><br>
			          {{$patientInfo->present_address')}}<br>
			          Phone: {{$patientInfo->mobile_no')}}<br>
			          Email: {{$patientInfo->email')}}
			        </address>
		        @endif
	      </div>
	      <!-- /.col -->
	      <div class="col-sm-4 invoice-col">
	        <b>Invoice {{$invoiceInfo->sale_invoice_id}}</b><br>
	        <br>
	        <b>Invoice Date:</b> {{$invoiceInfo->date}}<br>
	      </div>
	      <!-- /.col -->
     	</div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <table class="" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Test Name</th>
                            <th>Qty</th>
                            <th>Sale Price</th>
                            <th>Disc</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="service_content">
                        @if(count($invoiceDetails)>0)
                        @foreach($invoiceDetails as $mainKey => $saleItems)
                            @foreach($saleItems as $packageKey => $packageItems)
                                @if($packageKey != 'No-Package')
                                <div class="">
                                    <tr id="" style="color: #0d5279; font-size: 18px; font-weight: bold;" class="Package-{{explode('-',$packageKey)[0]}}">
                                        <td colspan="6">
                                            {{$packageKey}}
                                        </td>
                                    </tr>
                                @endif
                                @foreach($packageItems as $groupKey => $groupItems)
                                    @if($groupKey == 'No-Group')
                                        <tr @if($packageKey == 'No-Package') class="Group-{{explode('-',$groupKey)[0]}}" @elseif($groupKey == 'No-Group') class="Package-{{explode('-',$packageKey)[0]}}" @else id="tr-{{$groupItems['diagnostic_test_id']}}" @endif>
                                            <td width="3%">1</td>
                                            <td width="40%">
                                                {{$groupItems['diagnostic_test_name']}}
                                                <div class="help-block with-errors"></div>
                                            </td>
                                            <td width="10%">
                                                <div class="input-group col-md-12">
                                                    
                                                    <span> {{$groupItems['quantity']}} </span>
                                                </div>
                                            </td>
                                            <td width="12%">
                                                <div class="input-group col-md-12">
                                                    <span>
                                                    	{{$groupItems['diagnostic_test_sale_price']}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td width="10%">
                                                <div class="input-group col-md-10">
                                                    <span>
                                                    	{{$groupItems['discount']}}
                                                    </span>
                                                </div>
                                            </td>
                                            <td width="17%">
                                                <div class="input-group col-md-10">
                                                    <span>
                                                    	{{$groupItems['total']}}
                                                    </span>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                    @else
                                        <tr @if($packageKey == 'No-Package') class="Group-{{explode('-',$groupKey)[0]}}" @else class="Package-{{explode('-',$packageKey)[0]}}" @endif style="color: #0d5279; font-size: 16px; font-weight: bold;">
                                            <td colspan="6"> {{$groupKey}}</td>
                                            
                                        </tr>
                                        @foreach($groupItems as $serviceKey => $saleItem)
                                            <tr @if($packageKey == 'No-Package') class="Group-{{explode('-',$groupKey)[0]}}" @else class="Package-{{explode('-',$packageKey)[0]}}" @endif>
                                                <td width="3%">1</td>
                                                <td width="40%">
                                                    {{$saleItem['diagnostic_test_name']}}
                                                    <div class="help-block with-errors"></div>
                                                </td>
                                                <td width="10%">
                                                    <div class="input-group col-md-12">
                                                        <span>
                                                        	{{$saleItem['quantity']}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td width="12%">
                                                    <div class="input-group col-md-12">
                                                        <span>
                                                        	{{$saleItem['diagnostic_test_sale_price']}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td width="10%">
                                                    <div class="input-group col-md-10">
                                                        <span>
                                                        	{{$saleItem['discount']}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td width="17%">
                                                    <div class="input-group col-md-10">
                                                        <span>
                                                        	{{$saleItem['total']}}
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                <tr @if($packageKey == 'No-Package') class="Group-{{explode('-',$groupKey)[0]}}" @else class="Package-{{explode('-',$packageKey)[0]}}" @endif style="color: blue;">
                                    <td colspan="6">
                                        <hr style="margin-top:2px;margin-bottom:2px; border: 1px solid #4f819d;">
                                    </td>
                                </tr>
                                </div>
                            @endforeach
                        @endforeach
                        @endif
                        <tr>
			              <td colspan="4" style=""></td>
			              <td>Subtotal:</td>
			              <td colspan="2">{{$invoiceInfo->total_amount}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Discount:</td>
			              <td colspan="2">{{$invoiceInfo->discount}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Total:</td>
			              <td colspan="2">{{$invoiceInfo->total_amount - $invoiceInfo->discount}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Paid:</td>
			              <td colspan="2">{{$invoiceInfo->pay}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Due:</td>
			              <td colspan="2">{{$invoiceInfo->due}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Pay Note:</td>
			              <td colspan="2">{{$invoiceInfo->pay_note}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Return:</td>
			              <td colspan="2">{{$invoiceInfo->return}}</td>
			            </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
 

</section>