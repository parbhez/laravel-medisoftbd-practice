@extends('app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Doctor Information
            <small>Preview</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">HR</a></li>
            <li class="active">Doctor Information</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">

                    {{--<a data-toggle="modal" href="#modal" onclick="loadModal('diagnostic/add-diagnostic-test')" class="btn btn-info btn-md">--}}
                    {{--<i class="fa fa-plus"></i>&nbsp;--}}
                    {{--Add Diagnostic Test--}}
                    {{--</a>--}}

                    <a href="{{route('diagnostic-test')}}" class="btn btn-info btn-md">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        View Diagnostic Test
                    </a>

                    <a href="{{route('diagnostic.sale-diagnotic-test')}}" class="btn btn-info btn-md">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        Sale Diagnostic Test
                    </a>
                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('save-diagnosticTest.post')}}" id="myForm"
                              method="post" accept-charset="utf-8">
                            <!-- SmartWizard html -->

                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="diagnostic_test_name" class="col-md-2">Servie Category</label>
                                <div class="col-md-10">
                                    {!! Form::select('service_category_id',
                                              $service_categories
                                              ,null, ['class'=> 'form-control','placeholder'=>
                                              'Please Select Gender', 'id'=>'sc']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="diagnostic_test_name" class="col-md-2">Service Report Category</label>
                                <div class="col-md-10">
                                    {!! Form::select('service_sub_category_id',
                                              []
                                              ,null, ['class'=> 'form-control','placeholder'=>
                                              'Please Select Gender', 'id'=>'ssc']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="form-group" id="firstrow">

                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <a href="javascript:;" class="btn btn-success btn-add-row">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- /.box-header -->
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
                                    <!-- /.box-body -->
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info pull-right">Submut</button>
                                </div>
                            </div>

                            <hr>

                        </form>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information
                about the plugin.
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#doctorDatatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                'order': [[0, "asc"]],
                ajax: '{{ route("diagnostic.getDiagnosticTest.ajax") }}',
                columns: [
                    {data: 'diagnostic_test_name', name: 'diagnostic_test_name', orderable: true, searchable: true},
                    {data: 'diagnostic_test_price', name: 'diagnostic_test_price', orderable: true, searchable: true},
                    {
                        data: 'diagnostic_test_sale_price',
                        name: 'diagnostic_test_sale_price',
                        orderable: true,
                        searchable: true
                    },
                    {data: 'status', name: 'status', orderable: true, searchable: false},
                    {data: 'action', name: 'action', orderable: true, searchable: false},
                ]
            });

            $('#sc').change(function () { //any select change on the dropdown with id  trigger this code
                $("#ssc > option").remove(); //first of all clear select items
                var sc_id = $('#sc').val(); // here we are taking  id of the selected one.
                $.ajax({
                    type: "GET",
                    data: {id: sc_id},
                    url: "{{url('diagnostic/get-diagnostic-ssc')}}", //here we are calling our user controller and  method with the id
                    success: function (categories) //we're calling the response json array 'categories'
                    {
                        $.each(categories, function (id, category) //here we're doing a foeach loop round each cat with id as the key and cat as the value
                        {
                            var opt = $('<option />'); // here we're creating a new select option with for each cat
                            opt.val(id);
                            opt.text(category);
                            $('#ssc').append(opt); //here we will append these new select options to a dropdown with the id 'categories'
                        });
                    }
                });
            });
        });

        function updateStatus(modelReference, action, id) {
            var reference = $("#reference_" + id);
            if (action == 'delete') {
                if (!confirm('Do you want to Delete ?')) {
                    return false;
                }
            }
            $.ajax({
                url: "update-status/" + modelReference + "/" + action + "/" + id,
                method: "GET",
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
                        if (action == 'active') {
                            // reference.
                            reference.prev().show().prev().hide();
                            reference.parent().prev().children().next().show().prev().hide();
                        } else if (action == 'inactive') {
                            reference.prev().hide().prev().show();
                            reference.parent().prev().children().next().hide().prev().show();
                        } else if (action == 'delete') {
                            reference.parent().parent().hide(1000).remove();
                        }
                        $('.box-modal-message').show();
                        $('.messageBodySuccess').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
                    } else {
                        $('.box-modal-message').show();
                        $('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
                    }
                },
                error: function (data) {
                    $('.box-modal-message').show();
                    $('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
                }
            });
        }

        $('.btn-add-row').on('click', function () {
            var conID = $(this).parent().parent().parent().attr('id');
            var baseUrl = '<?php echo URL::to(''); ?>';
            $.get(baseUrl + '/' + 'diagnostic/add-content', function (data) {
                $("#" + conID).append(data);
            });
        });

        $('.btn-remove-row').on('click', function () {
            alert('Done');
//            $(this).parent().parent().remove();
        });

    </script>
@endsection

