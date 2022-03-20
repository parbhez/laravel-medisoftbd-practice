@extends('app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Patient Information
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
                    <a href="{{route('outdoor.add-patient')}}" class="btn btn-info btn-md">
                        <i class="fa fa-plus"></i>&nbsp;
                        Add Patient
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
                        <table id="patientDatatable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Patient ID</th>
                                <th>Mobile</th>
                                <th>Blood Group</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($patients) > 0)
                                @foreach($patients as $key => $patient)

                                    <tr>
                                        <td>{{$patient->user->full_name}}</td>

                                        <td>{{$patient->patient_id}}</td>

                                        <td>
                                            {{$patient->user->mobile_no}}
                                        </td>

                                        <td>
                                            {{$patient->blood_group}}
                                        </td>
                                        <td>
                                            <label class="label label-warning"
                                                   style="@if($patient->user->status == 1) display: none; @endif">
                                                Inactive
                                            </label>
                                            <label class="label label-success"
                                                   style="@if($patient->user->status == 0) display: none; @endif">
                                                Active
                                            </label>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-success btn-xs"
                                               style="@if($patient->user->status == 1) display: none; @endif"
                                               onclick="updateStatus('active','patient',{{$patient->user->user_id}})">
                                                <i class="fa fa-check-square-o" title="Active"></i>
                                            </a>
                                            <a href="javascript:;" class="btn btn-warning btn-xs"
                                               style="@if($patient->user->status == 0) display: none; @endif"
                                               onclick="updateStatus('inactive','patient',{{$patient->user->user_id}})">
                                                <i class="fa fa-ban" title="Inactive"></i>
                                            </a>

                                            <a href="{{url('outdoor/edit-patient',$patient->patient_id)}}"
                                               class="btn btn-info btn-xs" id="reference_{{$patient->patient_id}}">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>
                                            <a href="javascript:;" class="btn btn-danger btn-xs"
                                               style="@if($patient->user->status == 2) display: none; @endif"
                                               onclick="updateStatus('delete','patient',{{$patient->user->user_id}})">
                                                <i class="fa fa-trash" title="Delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Patient Name</th>
                                <th>Mobile</th>
                                <th>Blood Group</th>
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
    </section>

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#patientDatatable')
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