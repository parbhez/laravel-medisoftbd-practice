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
                    <a href="{{route('hr.add-schedule')}}" class="btn btn-info btn-md">
                        <i class="fa fa-plus"></i>&nbsp;
                        Add Schedule
                    </a>

                    <a href="{{route('hr.block-schedule')}}" class="btn btn-danger btn-md">
                        <i class="fa fa-plus"></i>&nbsp;
                        Block Schedule
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
                                <th>Doctor Name</th>
                                <th>Schedule Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($schedules) > 0)
                                @foreach($schedules as $key => $schedule)

                                    <tr>
                                        <td>{{$schedule->user->full_name}}</td>

                                        <td>
                                            {{$schedule->schedule_date}}
                                        </td>

                                        <td>
                                            <a href="javascript:;" class="btn btn-success btn-xs"
                                               style="@if($schedule->status == 1) display: none; @endif"
                                               onclick="updateStatus('active','schedule',{{$schedule->schedule_id}})">
                                                <i class="fa fa-check-square-o" title="Active"></i>
                                            </a>
                                            <a href="javascript:;" class="btn btn-warning btn-xs"
                                               style="@if($schedule->status == 0) display: none; @endif"
                                               onclick="updateStatus('inactive','schedule',{{$schedule->schedule_id}})">
                                                <i class="fa fa-ban" title="Inactive"></i>
                                            </a>

                                            <a href="{{url('hr/edit-schedule',$schedule->schedule_id)}}"
                                               class="btn btn-info btn-xs" id="reference_{{$schedule->schedule_id}}">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>
                                            <a href="javascript:;" class="btn btn-danger btn-xs"
                                               style="@if($schedule->status == 2) display: none; @endif"
                                               onclick="updateStatus('delete','schedule',{{$schedule->schedule_id}})">
                                                <i class="fa fa-trash" title="Delete"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Schedule Date</th>
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
    </section>

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#doctorDatatable')
                .addClass('nowrap')
                .dataTable({
                    responsive: true,
                    columnDefs: [
                        {targets: [-1, -3], className: 'dt-body-right'}
                    ]
                });

        });

        function updateStatus(action, url, id) {
            var reference = $("#reference_" + id);
            if (action == 'delete') {
                if (!confirm('Do you want to Delete ?')) {
                    return false;
                }
            }

            $.ajax({
                url: "update-" + url + '-status/' + action + '/' + id,
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

                        $('.box-body-second').show();
                        $('.messageBodySuccess').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
                    } else {
                        $('.box-body-second').show();
                        $('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
                    }
                },
                error: function (data) {
                    $('.box-body-second').show();
                    $('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
                }
            });
        }

    </script>
@endsection