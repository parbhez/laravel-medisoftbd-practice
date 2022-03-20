
@foreach($services as $packageKey => $packageItems)
    @if($packageKey != 'No-Package')
        <tr id="" style="color: #0d5279; font-size: 18px; font-weight: bold;">
            <td colspan="6"> {{$packageKey}}</td>
            <td width="8%">
                <a href="javascript:;" class="btn btn-danger btn-remove-row">
                    <i class="fa fa-minus"></i>
                </a>
            </td>
        </tr>
    @endif
    @foreach($packageItems as $groupKey => $groupItems)
        @if($groupKey == 'No-Group')
            <tr id="tr-{{$groupItems['diagnostic_test_id']}}">
                <td width="3%">1</td>
                <td width="40%">
                    {{$groupItems['diagnostic_test_name']}}
                    <div class="help-block with-errors"></div>
                </td>
                <td width="10%">
                  <div class="input-group col-md-12">
                      <input type="text" id="quantity-{{$groupItems['diagnostic_test_id']}}" name="quantity" value="1" class="form-control">
                  </div>
                </td>
                <td width="12%">
                  <div class="input-group col-md-12">
                      <input type="text" id="salePrice-{{$groupItems['diagnostic_test_id']}}" name="diagnostic_test_sale_price[0]" value="{{$groupItems['diagnostic_test_sale_price']}}" class="form-control">
                  </div>
                </td>
                <td width="10%">
                  <div class="input-group col-md-10">
                      <input type="text" id="discount-{{$groupItems['diagnostic_test_id']}}" name="discount" value="0.00" class="form-control" readonly="">
                  </div>
                </td>
                <td width="17%">
                  <div class="input-group col-md-10">
                      <input type="text" id="total-{{$groupItems['diagnostic_test_id']}}" name="total" value="{{$groupItems['diagnostic_test_sale_price']}}" class="form-control" readonly="">
                  </div>
                </td>
                <td width="8%">
                    @if($packageKey == 'No-Package' && $groupKey == 'No-Group')
                        <a href="javascript:;" class="btn btn-danger btn-remove-row">
                            <i class="fa fa-minus"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @else
            <tr id="" style="color: #0d5279; font-size: 16px; font-weight: bold;">
                <td colspan="6"> {{$groupKey}}</td>
                <td width="8%">
                    <a href="javascript:;" class="btn btn-danger btn-remove-row">
                        <i class="fa fa-minus"></i>
                    </a>
                </td>
            </tr>
            @foreach($groupItems as $serviceKey => $service)
                <tr id="tr-{{$service['diagnostic_test_id']}}">
                    <td width="3%">1</td>
                    <td width="40%">
                        {{$service['diagnostic_test_name']}}
                        <div class="help-block with-errors"></div>
                    </td>
                    <td width="10%">
                      <div class="input-group col-md-12">
                          <input type="text" id="quantity-{{$service['diagnostic_test_id']}}" name="quantity" value="1" class="form-control">
                      </div>
                    </td>
                    <td width="12%">
                      <div class="input-group col-md-12">
                          <input type="text" id="salePrice-{{$service['diagnostic_test_id']}}" name="diagnostic_test_sale_price[0]" value="{{$service['diagnostic_test_sale_price']}}" class="form-control">
                      </div>
                    </td>
                    <td width="10%">
                      <div class="input-group col-md-10">
                          <input type="text" id="discount-{{$service['diagnostic_test_id']}}" name="discount" value="0.00" class="form-control" readonly="">
                      </div>
                    </td>
                    <td width="17%">
                      <div class="input-group col-md-10">
                          <input type="text" id="total-{{$service['diagnostic_test_id']}}" name="total" value="{{$service['diagnostic_test_sale_price']}}" class="form-control" readonly="">
                      </div>
                    </td>
                    <td width="8%">
                        
                    </td>
                </tr>
            @endforeach
        @endif
    @endforeach
        <tr id="" style="color: blue;">
            <td colspan="7">
                <hr style="margin-top:2px;margin-bottom:2px; border: 1px solid #4f819d;">
            </td>
        </tr>
@endforeach
<script type="text/javascript">
    $('.btn-remove-row').on('click', function () {
        location.reload()
        $(this).parent().parent().remove();
        $("#search").val('');
        totalCount();
    });
</script>

