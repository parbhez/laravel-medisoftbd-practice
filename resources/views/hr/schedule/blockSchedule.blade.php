@extends('app')

@section('extra-css')
    <link rel="stylesheet" href="{{URL::to('public/assets/plugins/smartwizard/css/smart_wizard.css')}}">
    <link rel="stylesheet" href="{{URL::to('public/assets/plugins/smartwizard/css/smart_wizard_theme_arrows.css')}}">
    <link rel="stylesheet" href="{{URL::to('public/assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
    <style>
        .datepicker {
            z-index: 9999 !important;
        }</style>
@endsection

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Doctor Information
            <small>Add Doctor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">HR</a></li>
            <li class="active">Doctor Information</li>
            <li class="active">Add Doctor Information</li>
        </ol>
    </section>
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">

            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{{route('hr.schedule')}}" class="btn btn-info btn-md">
                        <i class="fa fa-hand-o-left"></i>&nbsp;
                        View Appointment
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

                    <div class="col-md-4">

                        <form action="{{route('hr.get-schedule')}}" class="form-horizontal" id="myForm"
                              role="form"
                              data-toggle="validator" method="post" accept-charset="utf-8" novalidate="true"
                              enctype="multipart/form-data">
                            <!-- SmartWizard html -->

                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="designation" class="col-md-4">Doctor:</label>
                                <div class="col-md-8">
                                    {!! Form::select('user_id',
                                    $doctors
                                    ,null, ['class'=>
                                    'form-control','placeholder'=>
                                    'Please Select Doctor', 'id'=>'user_id']) !!}

                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="dob" class="col-md-4">From Date</label>
                                <div class="col-md-8">
                                    <input type="text" name="start_date" id="start_date"
                                           class="form-control pull-right datepicker">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="dob" class="col-md-4">To Date</label>
                                <div class="col-md-8">
                                    <input type="text" name="end_date" id="end_date"
                                           class="form-control pull-right datepicker">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>


                            <button id="appointment_schedule" type="submit" class="btn btn-info pull-right">Get
                                Appointment
                                Schedule List
                            </button>


                        </form>

                    </div>

                    <div class="col-md-8" id="tabledata">

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

@section('extra-js')
    <script src="{{URL::to('public/assets/plugins/validator/validator.min.js')}}"></script>
    <script src="{{URL::to('public/assets/plugins/smartwizard/js/jquery.smartWizard.js')}}"></script>
    <script src="{{URL::to('public/assets/dist/js/addrow-v2.js')}}"></script>
    <script src="{{URL::to('public/assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            var btnFinish = $('<button></button>').text('Finish')
                .addClass('btn btn-info')
                .on('click', function () {
                    if (!$(this).hasClass('disabled')) {
                        var elmForm = $("#myForm");
                        if (elmForm) {
                            elmForm.validator('validate');
                            var elmErr = elmForm.find('.has-error');
                            if (elmErr && elmErr.length > 0) {
                                alert('Oops we still have error in the form');
                                return false;
                            } else {
                                alert('Great! we are ready to submit form');
                                elmForm.submit();
                                return false;
                            }
                        }
                    }
                });
            var btnCancel = $('<button></button>').text('Cancel')
                .addClass('btn btn-danger')
                .on('click', function () {
                    $('#smartwizard').smartWizard("reset");
                    $('#myForm').find("input, textarea").val("");
                });
            // Smart Wizard
            $('#smartwizard').smartWizard({
                selected: 0,
                theme: 'dots',
                transitionEffect: 'fade',
                toolbarSettings: {
                    toolbarPosition: 'bottom',
                    toolbarButtonPosition: 'right',
                    toolbarExtraButtons: [btnFinish, btnCancel]
                },
                anchorSettings: {
                    markDoneStep: true, // add done css
                    markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                    removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                    enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                }
            });

            $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
                var elmForm = $("#form-step-" + stepNumber);
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if (stepDirection === 'forward' && elmForm) {
                    elmForm.validator('validate');
                    var elmErr = elmForm.children('.has-error');
                    if (elmErr && elmErr.length > 0) {
                        // Form validation failed
                        return false;
                    }
                }
                return true;
            });

            $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
                // Enable finish button only on last step
                if (stepNumber == 3) {
                    $('.btn-finish').removeClass('disabled');
                } else {
                    $('.btn-finish').addClass('disabled');
                }
            });

            //Date picker

            $('.datepicker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            }).on('changeDate', function (ev) {
                // alert('on select triggered');
            });

        });


        function PrescriptionFeeAction() {
            if (document.getElementById('allow_fee').checked) {
                document.getElementById('prescription_fee').style.display = 'block';
            } else {
                document.getElementById('prescription_fee').style.display = 'none';
            }
        }


        function doctorCommision() {
            document.getElementById('comission_fee').style.display = 'block';
        }


        $("#appointment_schedule").click(function (e) {
            e.preventDefault();

            var userId = $('#user_id').find(":selected").val();
            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();

            $.ajax({
                url: "get-schedule",
                method: "GET",
                dataType: "json",
                data: {
                    user_id: userId,
                    start_date: startDate,
                    end_date: endDate,
                },
                success: function (data) {
                    if (data.success == true) {
                        $('#tabledata').html(data.view);
                        $('.box-modal-message').show();
                        $('.messageBodySuccess').slideDown(1000).delay(3000).slideUp(1000).children().next()
                            .html(data.message);
                    } else {
                        $('#tabledata').html('');
                        $('.box-modal-message').show();
                        $('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next()
                            .html(data.message);
                    }
                },
                error: function (data) {
                    $('.box-modal-message').show();
                    $('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(
                        data.message);
                }
            });
        });

    </script>

@endsection
