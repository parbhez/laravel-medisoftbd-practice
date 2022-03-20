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

                <!-- {{--<a data-toggle="modal" href="#modal" onclick="loadModal('diagnostic/add-diagnostic-test')" class="btn btn-info btn-md">--}}
                {{--<i class="fa fa-plus"></i>&nbsp;--}}
                {{--Add Diagnostic Test--}}
                {{--</a>--}} -->

                    <a href="{{route('add-diagnostic-test-new')}}" class="btn btn-info btn-md">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        Add Diagnostic Test
                    </a>

                    <a href="{{route('add-diagnostic-service-group')}}" class="btn btn-info btn-md">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        Add Diagnostic Test Group
                    </a>

                    <a href="{{route('add-diagnostic-service-package')}}" class="btn btn-info btn-md">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        Add Diagnostic Test Package
                    </a>

                    <a href="{{route('view-diagnostic-service-group')}}" class="btn btn-info btn-md">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        View Diagnostic Test Group
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
                        <table id="doctorDatatable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Diagnostic Test Name</th>
                                <th>Service Category</th>
                                <th>Service Sub Category</th>
                                <th>Test Price</th>
                                <th>Test Sale Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Diagnostic Test Name</th>
                                <th>Service Category</th>
                                <th>Service Sub Category</th>
                                <th>Test Price</th>
                                <th>Test Sale Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>

                        </table>
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
                    {data: 'service_category', name: 'service_category', orderable: true, searchable: true},
                    {data: 'service_sub_category', name: 'service_sub_category', orderable: true, searchable: true},
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

    </script>
@endsection

