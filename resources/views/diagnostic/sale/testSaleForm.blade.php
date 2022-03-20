@extends('app')
@section('content')
        
    <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Sale Register
    <small>Preview</small>
    <a href="{{url('diagnostic/empty-sale-cart')}}" class="btn btn-danger"> Empty Cart</a>
  </h1>

    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">HR</a></li>
        <li class="active">Setup</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- SELECT2 EXAMPLE -->
<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Test Name</th>
                                    <th>Qty</th>
                                    <th>Sale Price</th>
                                    <th>Disc</th>
                                    <th>Total</th>
                                    <th>Action</th>
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
                                                <td width="8%">
                                                    <a href="javascript:;" class="btn btn-danger btn-remove-row">
                                                        <i class="fa fa-minus"></i>
                                                    </a>
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
                                                            <input type="text" id="quantity-{{$groupItems['diagnostic_test_id']}}" name="quantity" value="{{$groupItems['quantity']}}" class="form-control" readonly="">
                                                            <span> </span>
                                                        </div>
                                                    </td>
                                                    <td width="12%">
                                                        <div class="input-group col-md-12">
                                                            <input type="text" id="salePrice-{{$groupItems['diagnostic_test_id']}}" name="diagnostic_test_sale_price[0]" value="{{$groupItems['diagnostic_test_sale_price']}}" class="form-control">
                                                        </div>
                                                    </td>
                                                    <td width="10%">
                                                        <div class="input-group col-md-10">
                                                            <input type="text" id="discount-{{$groupItems['diagnostic_test_id']}}" name="discount" value="{{$groupItems['discount']}}" class="form-control" readonly="">
                                                        </div>
                                                    </td>
                                                    <td width="17%">
                                                        <div class="input-group col-md-10">
                                                            <input type="text" id="total-{{$groupItems['diagnostic_test_id']}}" name="total" value="{{$groupItems['total']}}" class="form-control" readonly="">
                                                        </div>
                                                    </td>
                                                    <td width="8%">
                                                        @if($packageKey == 'No-Package' && $groupKey == 'No-Group')
                                                            <a href="javascript:;" class="btn btn-danger btn-remove-row" data-id="{{$groupItems['diagnostic_test_id']}}">
                                                                <i class="fa fa-minus"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @else
                                                <tr @if($packageKey == 'No-Package') class="Group-{{explode('-',$groupKey)[0]}}" @else class="Package-{{explode('-',$packageKey)[0]}}" @endif style="color: #0d5279; font-size: 16px; font-weight: bold;">
                                                    <td colspan="6"> {{$groupKey}}</td>
                                                    <td width="8%">
                                                        @if($packageKey == 'No-Package')
                                                            <a href="javascript:;" class="btn btn-danger btn-remove-row">
                                                                <i class="fa fa-minus"></i>
                                                            </a>
                                                        @endif
                                                    </td>
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
                                                                <input type="text" id="quantity-{{$saleItem['diagnostic_test_id']}}" name="quantity" value="{{$saleItem['quantity']}}" class="form-control" readonly="">
                                                                <span> </span>
                                                            </div>
                                                        </td>
                                                        <td width="12%">
                                                            <div class="input-group col-md-12">
                                                                <input type="text" id="salePrice-{{$saleItem['diagnostic_test_id']}}" name="diagnostic_test_sale_price[0]" value="{{$saleItem['diagnostic_test_sale_price']}}" class="form-control">
                                                            </div>
                                                        </td>
                                                        <td width="10%">
                                                            <div class="input-group col-md-10">
                                                                <input type="text" id="discount-{{$saleItem['diagnostic_test_id']}}" name="discount" value="{{$saleItem['discount']}}" class="form-control" readonly="">
                                                            </div>
                                                        </td>
                                                        <td width="17%">
                                                            <div class="input-group col-md-10">
                                                                <input type="text" id="total-{{$saleItem['diagnostic_test_id']}}" name="total" value="{{$saleItem['total']}}" class="form-control" readonly="">
                                                            </div>
                                                        </td>
                                                        <td width="8%">
                                                           
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                        <tr @if($packageKey == 'No-Package') class="Group-{{explode('-',$groupKey)[0]}}" @else class="Package-{{explode('-',$packageKey)[0]}}" @endif style="color: blue;">
                                            <td colspan="7">
                                                <hr style="margin-top:2px;margin-bottom:2px; border: 1px solid #4f819d;">
                                            </td>
                                        </tr>
                                        </div>
                                    @endforeach
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="col-md-12 test-scan">
                            <div class="col-md-3 find-tet-text"> Find Test Name</div>
                            <div class="col-md-3">
                                <select class="form-control sale_type" name="sale_type" style="height: 40px;">
                                    <option value="0" disabled="" selected=""> Please Select a type</option>
                                    <option value="1"> Service Sale</option>
                                    <option value="2"> Group Sale</option>
                                    <option value="3"> Package Sale</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="search" name="q" class="form-control search-field" autofocus="yes">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-body">
                                <form name="form-sale" class="form-horizontal" action="{{route('diagnostic.completeDiagnosticSale.post')}}" method="post">
                                    <table class="table table-hover table-bordered" style="background-color: #EEE;">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <span style="font-weight: bold; font-size: 20px; color: #046f3e;">
                                                        Patient: 
                                                    </span>
                                                </td>
                                                <td style="text-align: center;">
                                                    
                                                    @if(!Session::has('patientInfo'))
                                                        <input type="text" id="searchPatient" name="patient_name" class="form-control search-field" autofocus="yes">
                                                    @else
                                                    <span style="font-weight: bold; font-size: 20px; color: #0a5077;"> {{Session::get('patientInfo.patient_name')}}</span>
                                                    <a href="{{route('diagnostic.remove-patient-from-sale')}}" class="btn btn-danger btn-xs pull-right"> Remove </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span style="font-size: 16px;"> Branch </span></td>
                                                <td> 
                                                    <div class="input-group col-md-10 col-md-offset-1">
                                                        <span style="font-size: 16px;"> Main Branch </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span style="font-size: 16px;"> Date </h4></td>
                                                <td> 
                                                    <div class="input-group col-md-10 col-md-offset-1">
                                                        {{csrf_field()}}
                                                        <input type="text" class="form-control pull-right" name="invoice_date" id="datepicker" value="{{date('Y-m-d')}}">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span style="font-size: 16px;"> Payment Type </span></td>
                                                <td> 
                                                    <div class="input-group col-md-10 col-md-offset-1">
                                                        <select name="payment_type" class="form-control select2">
                                                            <option disabled="" selected="">
                                                                Please Select an option
                                                            </option>
                                                            <option value="1"> Cash </option>
                                                            <option value="2"> Debit Card </option>
                                                            <option value="3"> Credit Card</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span style="font-size: 16px;"> Sub Total  </span></td>
                                                <td>
                                                    <div id="invoice-sub-total" class="input-group col-md-11 col-md-offset-1">
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span style="font-size: 16px;"> Discount </span></td>
                                                <td>
                                                    <div class="input-group col-md-11 col-md-offset-1">
                                                         <input type="number" class="form-control col-md-3" name="discount_percent" readonly="">
                                                        <span class="input-group-addon"><b>%</b></i></span>

                                                        <input id="invoice-discount-taka" type="number" class="form-control col-md-6 col-md-offset-1" name="discount_taka" value="0">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-4"><span style="font-size: 16px;"> Total Amount </span></td>
                                                <td>
                                                    <div id="invoice-total" class="input-group col-md-11 col-md-offset-1">
                                                        1000.00 
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> <span style="font-size: 16px;"> Pay </span> </td>
                                                <td>
                                                    <div class="input-group col-md-11 col-md-offset-1">
                                                        <input id="invoice-pay" type="number" class="form-control" name="pay"readonly="">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> <span style="font-size: 16px;"> Pay Note </span> </td>
                                                <td>
                                                    <div class="input-group col-md-11 col-md-offset-1">
                                                        <input id="pay-note" type="number" class="form-control" name="pay_note" value="">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> <span style="font-size: 16px;"> Return </span> </td>
                                                <td>
                                                    <div class="input-group col-md-11 col-md-offset-1">
                                                        <span id="return" style="font-size: 16px;"> 0.00 </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="input-group col-md-11 col-md-offset-1">

                                                        <button type="submit" class="btn btn-success btn-sm"> Complete Sale </button>
                                                        &nbsp;
                                                        <button type="reset" class="btn btn-warning btn-sm"> Reset Form </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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

        $(document).ready(function(){
            var salePriceElements = $('input[name*="diagnostic_test_sale_price"]');
            var total = 0;
            for (i = 0; i < salePriceElements.length; i++) {
                total = parseFloat(total) + parseFloat($(salePriceElements[i]).val());
            }
            $("#invoice-sub-total").html(total.toFixed(2));
            $("#invoice-total").html(total.toFixed(2));
            $("#invoice-pay").val(total.toFixed(2));
            $("#pay-note").val(total.toFixed(2));
        });


        $('.sale_type').on('change', function(){
            $('.search-field').val('').focus();
        });

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
                    totalCount();
                });
            });
            function totalCount() {
                var salePriceElements = $('input[name*="diagnostic_test_sale_price"]');
                var total = 0;
                for (i = 0; i < salePriceElements.length; i++) {
                    total = parseFloat(total) + parseFloat($(salePriceElements[i]).val());
                }
                $("#invoice-sub-total").html(total.toFixed(2));
                $("#invoice-total").html(total.toFixed(2));
                $("#invoice-pay").val(total.toFixed(2));
                $("#pay-note").val(total.toFixed(2));
            }


            var bloodhoundForPatient = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: baseUrl + '/diagnostic/search-patient-for-sale?patient_name=%QUERY%',
                    wildcard: '%QUERY%',
                    prepare: function (query, settings) {
                        settings.url = settings.url.replace('%QUERY', query);
                        return settings;
                    },
                }
            });

            $('#searchPatient').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'patient_name',
                source: bloodhoundForPatient,
                limit: 10,
                display: function (data) {
                    console.log(data);
                    return data.patient_name  //Input value to be set when you select a suggestion.
                },
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        return '<div style="cursor: pointer; font-weight:normal; margin-top:-10px ! important;" class="list-group-item">' + data.patient_name + '</div></div>'
                    }
                }
            }).on('typeahead:selected', function (obj, patientData) {
                var patientId = patientData.patient_id;
                var baseUrl = '<?php echo URL::to(''); ?>';
                $.get(baseUrl + '/' + 'diagnostic/add-patient-to-sale/'+ patientId, function (data) {
                    console.log(data);
                    location.reload();
                    return false;
                    $("#service_content").append(data);
                    $("#search").val('');
                    totalCount();
                });
            });
        });

        $("#invoice-discount-taka").on('keyup', function(){
            var discount = parseFloat($(this).val());
            var salePriceElements = $('input[name*="diagnostic_test_sale_price"]');
            var total = 0;
            for (i = 0; i < salePriceElements.length; i++) {
                total = parseFloat(total) + parseFloat($(salePriceElements[i]).val());
            }
            $("#invoice-sub-total").html(total.toFixed(2));
            if(discount>total){
                discount = total;
                $(this).val(total);
            }
            var finalTotal = total - discount;
            $("#invoice-total").html(finalTotal.toFixed(2));
            $("#invoice-pay").val(finalTotal.toFixed(2));
            $("#pay-note").val(finalTotal.toFixed(2));
        });

        $("#pay-note").on('keyup', function(){
            var payNote = parseFloat($(this).val());
            var pay = parseFloat($("#invoice-pay").val());
            var returnTaka = payNote - pay;
            if(returnTaka>0){
                $("#return").html(returnTaka.toFixed(2));
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