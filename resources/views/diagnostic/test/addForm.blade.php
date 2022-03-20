<div class="row">

    <div class="col-md-12 row">
        <div class="pull-right">
            <a href="javascript:;" class="btn btn-danger btn-remove-row">
                <i class="fa fa-minus"></i>
            </a>
        </div>
    </div>

    <div class="box-body">

        <div class="col-md-4">
            <div class="form-group">
                <label>Service Name</label>
                <input type="text" class="form-control" name="diagnostic_test_name[]"
                       placeholder="Service Name">
            </div>

        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Service Price</label>
                <input type="text" class="form-control" name="diagnostic_test_price[]"
                       placeholder="Service Price">
            </div>

        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Service Sale Price</label>
                <input type="text" class="form-control"
                       name="diagnostic_test_sale_price[]"
                       placeholder="Service Sale Price">
            </div>

        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Result Type</label>
                {!! Form::select('diagnostic_test_result_type[]',
                    [
                    '1'=>'Positive/Negative',
                    '2'=>'Yes/No',
                    '3'=>'Unit Base',
                    ]
                    ,null, ['class'=> 'form-control','placeholder'=>
                    'Please Select Result Type']) !!}
            </div>

        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Result Unit</label>
                <input type="text" class="form-control"
                       name="diagnostic_test_result_unit[]"
                       placeholder="Result Unit">
            </div>

        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Result Normal Value</label>
                <textarea placeholder="" class="form-control"
                          name="diagnostic_test_normal_value[]"></textarea>
            </div>

        </div>

    </div>

</div>


<script>
    $('.btn-remove-row').on('click', function () {
        $(this).parent().parent().parent().remove();
    });
</script>

