@extends('app')

@section('extra-css')
    <link rel="stylesheet" href="{{URL::to('public/assets/plugins/smartwizard/css/smart_wizard.css')}}">
    <link rel="stylesheet" href="{{URL::to('public/assets/plugins/smartwizard/css/smart_wizard_theme_arrows.css')}}">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Employee Information
        <small>Preview</small>
      </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">HR</a></li>
        <li class="active">Employee Information</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
	<!-- Custom Tabs -->
	<div class="nav-tabs-custom">
	    <ul class="nav nav-tabs">
	        <li class="active"><a href="#view-employee" data-toggle="tab">View Employee</a></li>
	        <li><a href="#add-employee" data-toggle="tab">Add Employee</a></li>
	        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
	    </ul>
	    <div class="tab-content">
	        <div class="tab-pane active" id="view-employee">
	        	<div class="box box-default">
		        	<div class="box-body">
			            <div class="row">
			                <div class="col-md-12">
			                	<table id="employeeDatatable" class="table table-bordered table-striped">
								    <thead>
								        <tr>
								            <th>Employee Name</th>
								            <th>User Name</th>
								            <th>Email</th>
								            <th>Mobile</th>
								            <th>Designation</th>
								            <th>Status</th>
								            <th>Action</th>
								        </tr>
								    </thead>
								    <tbody>
								    	@if(count($employees) > 0)
								    	@foreach($employees as $key => $employee)

								        <tr>
								            <td>{{$employee->user->full_name}}</td>
								            <td>
								            	{{$employee->user->user_name}}
								            </td>
								            <td>
								            	{{$employee->user->email}}
								            </td>
								            <td>
								            	{{$employee->user->mobile_no}}
								            </td>
								            <td>
								            	{{$employee->designation->designation_name}}
								            </td>
								            <td>
							            		<label class="label label-warning" style="@if($employee->user->status == 1) display: none; @endif">
							            			Inactive
							            		</label>
							            		<label class="label label-success"  style="@if($employee->user->status == 0) display: none; @endif">
							            			Active
							            		</label>
								            </td>
								            <td>
									            <a href="javascript:;" class="btn btn-success btn-xs" style="@if($employee->user->status == 1) display: none; @endif" onclick="updateStatus('active','employee',{{$employee->user->user_id}})">
									            	<i class="fa fa-check-square-o" title="Active"></i>	
									           	</a>
									           	<a href="javascript:;" class="btn btn-warning btn-xs" style="@if($employee->user->status == 0) display: none; @endif" onclick="updateStatus('inactive','employee',{{$employee->user->user_id}})">
									            	<i class="fa fa-ban" title="Inactive"></i>	
									           	</a>

									           	<a href="{{url('hr/edit-employee',$employee->employee_id)}}" class="btn btn-info btn-xs" id="reference_{{$employee->user->user_id}}">
									            	<i class="fa fa-edit" title="Edit"></i>	
									           	</a>
									           	<a href="javascript:;" class="btn btn-danger btn-xs" style="@if($employee->user->status == 2) display: none; @endif" onclick="updateStatus('delete','employee',{{$employee->user->user_id}})">
									            	<i class="fa fa-trash" title="Delete"></i>	
									           	</a>
								            </td>
								        </tr>
								        @endforeach
								        @endif
								    </tbody>
								    <tfoot>
								        <tr>
								            <th>Employee Name</th>
								            <th>User Name</th>
								            <th>Email</th>
								            <th>Contact</th>
								            <th>Designation</th>
								            <th>Station</th>
								            <th>Action</th>
								        </tr>
								    </tfoot>
								</table>
			                </div>
			            </div>
			        </div>
			        <div class="box-footer">
			            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about the plugin.
			        </div>
		    	</div>
	        </div>
	        <!-- /.tab-pane -->
	        <div class="tab-pane" id="add-employee">
	            <div class="box box-default">
		        	<div class="box-body">
			            <div class="row">
			                <div class="col-md-12">
			                	<form action="{{route('hr.save-employee.post')}}" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" novalidate="true" enctype="multipart/form-data">
			                        <!-- SmartWizard html -->
			                        <div id="smartwizard" class="sw-main sw-theme-arrows">
			                            <ul class="nav nav-tabs step-anchor">
			                                <li class="nav-item active"><a href="#step-1" class="nav-link">Step 1<br><small>Basic Information</small></a></li>
			                                <li class="nav-item"><a href="#step-2" class="nav-link">Step 2<br><small>Address</small></a></li>
			                                <li class="nav-item"><a href="#step-3" class="nav-link">Step 3<br><small>Login Information</small></a></li>
			                            </ul>

			                            <div class="sw-container tab-content" style="min-height: 152px;">

			                                <div id="step-1" class="tab-pane step-content" style="display: block;">
			                                    <div id="form-step-0" role="form" data-toggle="validator">
			                                        <div class="form-group">
			                                            <div class="col-md-12">
			                                                <label for="full_name" class="col-md-2">Full Name:</label>
			                                                <div class="col-sm-4">
			                                                    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Write your Full Name" required="">
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                                <label for="user_name" class="col-md-2">User Name:</label>
			                                                <div class="col-sm-4">
			                                                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Write your UserName" required="">
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                            </div>
			                                        </div>
			                                        {{csrf_field()}}
			                                        <div class="form-group">
			                                            <div class="col-md-12">
			                                                <label for="father_name" class="col-md-2">Father's Name:</label>
			                                                <div class="col-sm-4">
			                                                    <input type="text" class="form-control" name="father_name" id="father_name" placeholder="Write your Father Name">
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                                <label for="mother_name" class="col-md-2">Mother's Name:</label>
			                                                <div class="col-sm-4">
			                                                    <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Write your Mother Name">
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                            </div>
			                                        </div>
			                                        <div class="form-group">
			                                            <div class="col-md-12">
			                                                <label for="designation" class="col-md-2">Designation:</label>
			                                                <div class="col-sm-4">
			                                                    {{ Form::select('designation', $designations, null, ['class' => 'form-control select2', 'id' => 'designation','required' => 'required'] ) }}
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                                <label for="mobile_no" class="col-md-2">Mobile No:</label>
			                                                <div class="col-sm-4">
			                                                    <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile Number">
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                            </div>
			                                        </div>
			                                        <div class="form-group">
			                                            <div class="col-md-12">
			                                                <label for="dob" class="col-md-2">DOB:</label>
			                                                <div class="col-sm-4">
			                                                    <input type="text" class="form-control pull-right datepicker" id="dob" name="dob">
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                                <label for="gender" class="col-md-2">Gender:</label>
			                                                <div class="col-sm-4">
			                                                    <select class="form-control select2" name="gender" id="gender" required="">
			                                                        <option selected="" disabled="">Please Select a Designation</option>
			                                                        <option value="1">Male</option>
			                                                        <option value="2">Female</option>
			                                                        <option value="3">Other</option>
			                                                    </select>
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                            </div>
			                                        </div>

			                                        <div class="form-group">
			                                            <div class="col-md-12">
			                                                <label for="profile_image" class="col-md-2">Profile Image:</label>
			                                                <div class="col-sm-10">
			                                                    <input type="file" id="profile_image" name="profile_image">
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                            </div>
			                                        </div>
			                                    </div>
			                                </div>
			                                <div id="step-2" class="tab-pane step-content">
			                                    <div id="form-step-1" role="form" data-toggle="validator">
			                                        <div class="form-group">
			                                            <div class="col-md-12">
			                                                <label for="present_address" class="col-md-2">Present Address:</label>
			                                                <div class="col-sm-4">
			                                                    <textarea class="form-control" name="present_address" id="present_address" rows="3" placeholder="Write your Present address"></textarea>
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                                <label for="mother_name" class="col-md-2">Permanent Address:</label>
			                                                <div class="col-sm-4">
			                                                    <textarea class="form-control" name="permanent_address" id="permanent_address" rows="3" placeholder="Write your Permanent address"></textarea>
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                            </div>
			                                        </div>
			                                    </div>
			                                </div>
			                                <div id="step-3" class="tab-pane step-content">
			                                    <div id="form-step-2" role="form" data-toggle="validator">
			                                        <div class="form-group">
			                                            <div class="col-md-12">
			                                                <label for="email" class="col-md-2">Email:</label>
			                                                <div class="col-sm-10">
			                                                    <input type="email" class="form-control" name="email" id="email" placeholder="Write your Email Address" required="">
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                            </div>
			                                        </div>
			                                        <div class="form-group">
			                                            <div class="col-md-12">
			                                                <label for="password" class="col-md-2">Password:</label>
			                                                <div class="col-sm-4">
			                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="">
			                                                    <div class="help-block with-errors"></div>
			                                                </div>
			                                                <label for="confirm_password" class="col-md-2">Confirm Password:</label>
			                                                <div class="col-sm-4">
			                                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required="">
			                                                    <div class="help-block with-errors"></div>
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
	        </div>
	        <!-- /.tab-pane -->
	    </div>
	    <!-- /.tab-content -->
	</div>
	<!-- nav-tabs-custom -->
	<!-- SELECT2 EXAMPLE -->
        
</section>

@endsection

@section('extra-js')
    <script src="{{URL::to('public/assets/plugins/validator/validator.min.js')}}"></script>
    <script src="{{URL::to('public/assets/plugins/smartwizard/js/jquery.smartWizard.js')}}"></script>
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('#employeeDatatable')
			.addClass( 'nowrap' )
			.dataTable( {
				responsive: true,
				columnDefs: [
					{ targets: [-1, -3], className: 'dt-body-right' }
				]
			} );

		});
	$(document).ready(function(){
		var btnFinish = $('<button></button>').text('Finish')
            .addClass('btn btn-info')
            .on('click', function(){
                if( !$(this).hasClass('disabled')){
                    var elmForm = $("#myForm");
                    if(elmForm){
                        elmForm.validator('validate');
                        var elmErr = elmForm.find('.has-error');
                        if(elmErr && elmErr.length > 0){
                            alert('Oops we still have error in the form');
                            return false;
                        }else{
                            alert('Great! we are ready to submit form');
                            elmForm.submit();
                            return false;
                        }
                    }
                }
            });
        var btnCancel = $('<button></button>').text('Cancel')
            .addClass('btn btn-danger')
            .on('click', function(){
                $('#smartwizard').smartWizard("reset");
                $('#myForm').find("input, textarea").val("");
            });
            // Smart Wizard
        $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'dots',
            transitionEffect:'fade',
            toolbarSettings: {toolbarPosition: 'bottom',
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

        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
            var elmForm = $("#form-step-" + stepNumber);
            // stepDirection === 'forward' :- this condition allows to do the form validation
            // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
            if(stepDirection === 'forward' && elmForm){
                elmForm.validator('validate');
                var elmErr = elmForm.children('.has-error');
                if(elmErr && elmErr.length > 0){
                    // Form validation failed
                    return false;
                }
            }
            return true;
        });

        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
            // Enable finish button only on last step
            if(stepNumber == 3){
                $('.btn-finish').removeClass('disabled');
            }else{
                $('.btn-finish').addClass('disabled');
            }
        });

        //Date picker
        $('.datepicker').datepicker({
          autoclose: true
        });

	});

	function updateStatus(action,url,id)
	{
		var reference = $("#reference_"+id);
		if(action == 'delete'){
			if(!confirm('Do you want to Delete ?')){
				return false;
			}
		}

		$.ajax({
			url: "update-"+url+'-status/'+action+'/'+id,
		    method: "GET",
		    dataType: 'json',
		    success: function(data){
		    	if(data.success == true){
		    		if(action == 'active'){
		    			// reference.
			    		reference.prev().show().prev().hide();
			    		reference.parent().prev().children().next().show().prev().hide();
		    		}else if(action == 'inactive'){
		    			reference.prev().hide().prev().show();
		    			reference.parent().prev().children().next().hide().prev().show();
		    		}else if(action == 'delete'){
		    			reference.parent().parent().hide(1000).remove();
		    		}
		    		
		    		$('.box-body-second').show();
		    		$('.messageBodySuccess').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    	}else{
		    		$('.box-body-second').show();
		    		$('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    	}
		    },
		    error: function(data){
		    	$('.box-body-second').show();
		    	$('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    }
		});
	}

</script>
@endsection