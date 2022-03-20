@extends('app')
@section('content')
	<?php
		// print_r($receiptInfo);
		// exit;
	?>
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
          <small class="pull-right">Date: {{date('d F, Y')}}</small>
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
	        	@if(Session::has('patientInfo'))
			        <address>
			          <strong>{{Session::get('patientInfo.patient_name')}}</strong><br>
			          {{Session::get('patientInfo.patient_address')}}<br>
			          Phone: {{Session::get('patientInfo.patient_contact')}}<br>
			          Email: {{Session::get('patientInfo.email')}}
			        </address>
		        @endif
	      </div>
	      <!-- /.col -->
	      <div class="col-sm-4 invoice-col">
	        <b>Invoice {{$receiptInfo->invoice_id}}</b><br>
	        <br>
	        <b>Invoice Date:</b> {{date("d F, Y")}}<br>
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
                        @if(Session::has('saleItems'))
                        @foreach(Session::get('saleItems') as $mainKey => $saleItems)
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
			              <td colspan="2">{{$receiptInfo->total_amount}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Discount:</td>
			              <td colspan="2">{{$receiptInfo->discount}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Total:</td>
			              <td colspan="2">{{$receiptInfo->total_amount - $receiptInfo->discount}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Paid:</td>
			              <td colspan="2">{{$receiptInfo->pay}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Due:</td>
			              <td colspan="2">{{$receiptInfo->due}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Pay Note:</td>
			              <td colspan="2">{{$receiptInfo->pay_note}}</td>
			            </tr>
			            <tr>
			              <td colspan="4" style=""></td>
			              <td>Return:</td>
			              <td colspan="2">{{$receiptInfo->return}}</td>
			            </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
 

</section>
@endsection

@section('extra-js')
    <script src="{{URL::to('public/assets/plugins/typeahead.bundle.js')}}"></script>
@endsection
@section('script')
    <script type="text/javascript">
        var baseUrl = '<?php echo URL::to(''); ?>';
        var saleType = $('.sale_type').val();
        $(document).ready(function () {
            var bloodhound = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: baseUrl + '/diagnostic/search-service-for-sale?q=%QUERY%&saleType=%saleType%',
                    wildcard: '%QUERY%',
                    prepare: function (query, settings) {
                        settings.url = settings.url.replace('%QUERY', query);
                        settings.url = settings.url.replace('%saleType%', $(".sale_type").val());
                        return settings;
                    },
                }
            });
            $('#search').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'q',
                source: bloodhound,
                limit: 10,
                display: function (data) {

                    return data.service_name  //Input value to be set when you select a suggestion.
                },
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        return '<div style="cursor: pointer; font-weight:normal; margin-top:-10px ! important;" class="list-group-item">' + data.service_name + '</div></div>'
                    }
                }
            }).on('typeahead:selected', function (obj, serviceData) {
                var saleType = $('.sale_type').val();
                var DTID = serviceData.service_id;
                var baseUrl = '<?php echo URL::to(''); ?>';
                $.get(baseUrl + '/' + 'diagnostic/add-service-to-sale/'+saleType+'/'+ DTID, function (data) {
                    if(data.duplicate == true){
                        var qty       = $("#quantity-"+DTID);
                        var oldQty    = parseFloat(qty.val());
                        var newQty    = oldQty + 1;
                        var salePrice = parseFloat($("#salePrice-"+DTID).val());
                        var discount  = parseFloat($("#discount-"+DTID).val());
                        var total     = $("#total-"+DTID);
                        qty.val(newQty);
                        total.val(salePrice * newQty);
                        return false;
                    }
                    console.log(data);
                    $("#service_content").append(data);
                    $("#search").val('');
                    // totalCount();
                });
            });
            function totalCount() {
                var salePriceElements = $('input[name*="diagnostic_test_sale_price"]');
                var total = 0;
                for (i = 0; i < salePriceElements.length; i++) {
                    total = parseInt(total) + parseInt($(salePriceElements[i]).val());
                }
                $("#stotal").html(total);
            }
        });

        $('.btn-remove-row').on('click', function () {
            var baseUrl = '<?php echo URL::to(''); ?>';
            var thisProperty = $(this).parent().parent();
            var refId = thisProperty.attr('class');
            if(refId.split('-')[0] != 'Package' && refId.split('-')[0] != 'Group')
            {
                thisProperty.hide();
            }else{
                $("."+refId).hide();
            }
            return false;
            var id = $(this).attr('data-id');
            var baseUrl = '<?php echo URL::to(''); ?>';
            $.ajax({
                url: baseUrl + '/' + 'diagnostic/remove-service-from-sale'+ '/' +id,
                method   : "GET",
                dataType : "json",
                success: function(data){

                },
                error: function(data){

                }
            });
            $("#search").val('');
            totalCount();
        });
    </script>
@endsection