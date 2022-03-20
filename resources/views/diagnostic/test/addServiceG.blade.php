@if(count($services) > 0)
    <div>
        <?php $i = 0;?>

        <input type="hidden" name="service_group_id[]" value="{{$service_group_id}}">

        @foreach($services as $key => $service)

            <div class="row">

                @if($i==0)
                    @if($service_group_name!=null)
                        <label for="diagnostic_test_name" class="col-md-1">{{$service_group_name}}</label>
                        <div class="col-md-1">
                            <a href="javascript:;" class="btn btn-danger btn-remove-row">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="col-md-2">
                    </div>
                @endif
                <?php $i++;?>
                <input type="hidden" name="diagnostic_test_id[]" value="{{$service->diagnostic_test_id}}">
                <div class="col-md-2">
                    {{Form::text("diagnostic_test_name[]",
                         old("diagnostic_test_name") ? old("diagnostic_test_name") : (!empty($service) ? $service->diagnostic_test_name : null),
                         [
                            "class" => "form-control",
                            "placeholder" => "Service Name",
                         ])
                     }}
                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-md-2">

                    {{Form::text("diagnostic_test_price[]",
                    old("diagnostic_test_price") ? old("diagnostic_test_price") : (!empty($service) ? $service->diagnostic_test_price : 0.00),
                    [
                       "class" => "form-control",
                       "placeholder" => "Service price",
                    ])
                    }}

                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-md-2">

                    {{Form::text("diagnostic_test_sale_price[]",
                      old("diagnostic_test_sale_price") ? old("diagnostic_test_sale_price") : (!empty($service) ? $service->diagnostic_test_sale_price : 0.00),
                      [
                         "class" => "form-control",
                         "placeholder" => "Service Sale price",
                      ])
                      }}

                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-md-2">

                    {!! Form::select('diagnostic_test_result_type[]',
                               [
                               '1'=>'Positive/Negative',
                               '2'=>'Yes/No',
                               '3'=>'Unit Base',
                               ]
                               ,!empty($service) ? $service->diagnostic_test_result_type : null, ['class'=> 'form-control','placeholder'=>
                               'Please Select Result Type']) !!}

                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-md-2">

                    {{Form::text("diagnostic_test_unit[]",
                      old("diagnostic_test_unit") ? old("diagnostic_test_unit") : (!empty($service) ? $service->diagnostic_test_unit : null),
                      [
                         "class" => "form-control",
                         "placeholder" => "Service Result Unit",
                      ])
                      }}

                    <div class="help-block with-errors"></div>

                </div>
            </div>

        @endforeach

    </div>

@endif

<script>
    $('.btn-remove-row').on('click', function () {
        $(this).parent().parent().parent().remove();
        $("#search").val('');
        totalCount();
    });
</script>

