@extends('app')

@section('extra-css')
<link rel="stylesheet" href="{{URL::to('public/assets/plugins/smartwizard/css/smart_wizard.css')}}">
<link rel="stylesheet" href="{{URL::to('public/assets/plugins/smartwizard/css/smart_wizard_theme_arrows.css')}}">
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
                <a href="{{route('hr.doctor')}}" class="btn btn-info btn-md">
                    <i class="fa fa-hand-o-left"></i>&nbsp;
                    View Doctor
                </a>
            </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('hr.update-doctor.post')}}" id="myForm" role="form" data-toggle="validator"
                        method="post" accept-charset="utf-8" novalidate="true" enctype="multipart/form-data">
                        <!-- SmartWizard html -->

                        {{csrf_field()}}

                        <input type="hidden" value="{{$doctor->user->user_id}}" name="user_id">

                        <div id="smartwizard" class="sw-main sw-theme-arrows">

                            <ul class="nav nav-tabs step-anchor">
                                <li class="nav-item active"><a href="#step-1" class="nav-link">Step 1<br><small>Basic
                                            Information</small></a></li>
                                <li class="nav-item"><a href="#step-2" class="nav-link">Step 2<br><small>Doctor Profile</small></a></li>
                      
                            </ul>

                            <div class="sw-container tab-content" style="min-height: 1602px;">

                                <br>

                                <div id="step-1" class="tab-pane step-content" style="display: block;">

                                    <div id="form-step-0" role="form" data-toggle="validator">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="full_name" class="col-md-4">Full Name:</label>
                                                <div class="col-md-8">
                                                    <input type="text" value="{{$doctor->user->full_name}}" class="form-control"
                                                        name="full_name" id="full_name" placeholder="Write your Full Name"
                                                        required="">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_name" class="col-md-4">User Name:</label>
                                                <div class="col-md-8">
                                                    <input type="text" value="{{$doctor->user->user_name}}" class="form-control"
                                                        name="user_name" id="user_name" placeholder="Write your UserName"
                                                        required="">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="father_name" class="col-md-4">Father's Name:</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" value="{{$doctor->user->father_name}}"
                                                        name="father_name" id="father_name" placeholder="Write your Father Name">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mother_name" class="col-md-4">Mother's Name:</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" value="{{$doctor->user->mother_name}}"
                                                        name="mother_name" id="mother_name" placeholder="Write your Mother Name">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mobile_no" class="col-md-4">Mobile No:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" value="{{$doctor->user->mobile_no}}"
                                                        name="mobile_no" id="mobile_no" placeholder="Mobile Number">
                                                    <div class="help-block with-errors"></div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dob" class="col-md-4">DOB:</label>
                                                <div class="col-md-8">
                                                    <input type="text" value="{{$doctor->user->dob}}" class="form-control pull-right datepicker"
                                                        id="dob" name="dob">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender" class="col-md-4">Gender:</label>
                                                <div class="col-md-8">

                                                    {!! Form::select('gender',
                                                    [
                                                    '1'=>'Male',
                                                    '2'=>'Female',
                                                    '3'=>'Other',
                                                    ]
                                                    ,$doctor->user->gender, ['class'=> 'form-control','placeholder'=>
                                                    'Please Select Gender']) !!}

                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="profile_image" class="col-md-2">Profile Image:</label>

                                                @if(file_exists($doctor->user->profile_image))
                                                <img src="{{$doctor->user->profile_image}}" />
                                                @endif

                                                <div class="col-md-10">
                                                    <input type="file" id="profile_image" name="profile_image">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div id="step-2" class="tab-pane step-content">

                                    <div id="form-step-1" role="form" data-toggle="validator">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="designation" class="col-md-4">Designation:</label>
                                                <div class="col-md-8">

                                                    {!! Form::select('designation',
                                                    $designations
                                                    ,$doctor->designation_id, ['class'=>
                                                    'form-control','placeholder'=>
                                                    'Please Select Designation']) !!}


                                                    <div class="help-block with-errors"></div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="designation" class="col-md-4">Department:</label>
                                                <div class="col-md-8">
                                                    {!! Form::select('department',
                                                    $departments
                                                    ,$doctor->department_id, ['class'=>
                                                    'form-control','placeholder'=>
                                                    'Please Select Department']) !!}
                                                    <div class="help-block with-errors"></div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="designation" class="col-md-4">Educational Qualification:</label>
                                                <div class="col-md-8">
                                                    {!! Form::select('educational_qualification',
                                                    $educational_qualifications
                                                    ,$doctor->educational_qualification_id, ['class'=>
                                                    'form-control','placeholder'=>
                                                    'Please Select Designation']) !!}
                                                    <div class="help-block with-errors"></div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="designation" class="col-md-4">Medical Degree:</label>
                                                <div class="col-md-8">
                                                    {!! Form::select('medical_degree',
                                                    $medical_degrees
                                                    ,$doctor->medical_degree_id, ['class'=>
                                                    'form-control','placeholder'=>
                                                    'Please Select Degree']) !!}
                                                    <div class="help-block with-errors"></div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="present_address" class="col-md-2">Specialist:</label>
                                                <div class="col-md-10">
                                                    <textarea class="form-control" name="speciality" id="present_address"
                                                        rows="3" placeholder="Write Doctor Speciality">{{$doctor->speciality}}</textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="dob" class="col-md-2"></label>
                                                <div class="col-sm-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            {!! Form::checkbox('allow_prescription_fee',
                                                            $doctor->allow_prescription_fee,
                                                            $doctor->allow_prescription_fee=='1'?true:null, ['id'=>
                                                            'allow_fee', 'onclick'=>'PrescriptionFeeAction();']) !!}
                                                            Allow Prescription Fees
                                                        </label>
                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div id="prescription_fee" style="display:{{$doctor->allow_prescription_fee=='1'?'block':'none'}};">
                                                <div class="form-group">
                                                    <label for="mobile_no" class="col-md-2">Prescription Fee:</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="prescription_fee"
                                                            id="prescription_fee" value="{{$doctor->prescription_fee}}"
                                                            placeholder="Please Insert Prescription Fee">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="mobile_no" class="col-md-2"></label>
                                                <div class="col-sm-10">

                                                    <div class="radio">
                                                        <label>

                                                            {!! Form::radio('payment_receiving_process',
                                                            $doctor->payment_receiving_process,
                                                            ($doctor->payment_receiving_process=='1')) !!}

                                                            Received By Hospital With Appointment

                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>

                                                            {!! Form::radio('payment_receiving_process',
                                                            $doctor->payment_receiving_process,
                                                            ($doctor->payment_receiving_process=='2')) !!}
                                                            Received By Doctor With Appointment
                                                        </label>
                                                    </div>

                                                    <div class="help-block with-errors"></div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label for="mobile_no" class="col-md-2">Doctor Commision</label>

                                                <div class="col-sm-10">

                                                    <div class="radio">
                                                        <label>

                                                            {!! Form::radio('commission_type',
                                                            $doctor->commission_type,
                                                            ($doctor->payment_receiving_process=='1'),
                                                            ['onclick'=>'doctorCommision();']) !!}

                                                            Comission Type 1
                                                        </label>
                                                    </div>

                                                    <div class="radio">
                                                        <label>

                                                            {!! Form::radio('commission_type',
                                                            $doctor->commission_type,
                                                            ($doctor->payment_receiving_process=='2'),
                                                            ['onclick'=>'doctorCommision();']) !!}

                                                            Comission Type 2
                                                        </label>
                                                    </div>

                                                    <div class="help-block with-errors"></div>

                                                </div>

                                            </div>

                                            <div id="comission_fee" style="display:{{is_numeric($doctor->commission_type)?'block':'none'}};">
                                                <div class="form-group">
                                                    <label for="mobile_no" class="col-md-2">Comission Fee:</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="{{$doctor->commission}}"
                                                            name="commission" placeholder="Please Insert Comission Free">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

</section>

@endsection

@section('extra-js')
<script src="{{URL::to('public/assets/plugins/validator/validator.min.js')}}"></script>
<script src="{{URL::to('public/assets/plugins/smartwizard/js/jquery.smartWizard.js')}}"></script>
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
            autoclose: true
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

</script>

@endsection
