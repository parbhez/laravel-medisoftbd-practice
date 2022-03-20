
<div class="row">
    <div class="col-md-12">
    	<table id="designationDatatable" class="table table-bordered table-striped">
		    <thead>
		        <tr>
		            <th>Designation Type</th>
		            <th>Designation Name</th>
		            <th>Status</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		    <tbody>
		    	@if(count($designations) > 0)
		    	@foreach($designations as $key => $designation)
		        <tr>
		            <td>
		            	<span>
		            		{{Helper::designationName($designation->designation_type)}}
		            	</span>
		            	<select name="designation_type" id="designationType_{{$designation->designation_id}}" class="form-control" style="display: none;">
		            		<option selected="" disabled="">
		            			Please Select a Type
		            		</option>
		            		<option value="1" @if($designation->designation_type == 1) selected="" @endif> Employee </option>
		            		<option value="2" @if($designation->designation_type == 2) selected="" @endif> Doctor </option>
		            	</select>
		            	
		            </td>
		            <td>
		            	<span>{{$designation->designation_name}}</span>
		            	<input type="text" name="designation_name" class="form-control" id="designationName_{{$designation->designation_id}}" value="{{$designation->designation_name}}" style="display: none;">
		        	</td>
		            <td>
	            		<label class="label label-warning" style="@if($designation->status == 1) display: none; @endif">
	            			Inactive
	            		</label>
	            		<label class="label label-success"  style="@if($designation->status == 0) display: none; @endif">
	            			Active
	            		</label>
		            </td>
		            <td>
			            <a href="javascript:;" class="btn btn-success btn-xs" style="@if($designation->status == 1) display: none; @endif" onclick="updateStatus('designation','active',{{$designation->designation_id}})">
			            	<i class="fa fa-check-square-o" title="Active"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-warning btn-xs" style="@if($designation->status == 0) display: none; @endif" onclick="updateStatus('designation','inactive',{{$designation->designation_id}})">
			            	<i class="fa fa-ban" title="Inactive"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-info btn-xs edit-designation" id="reference_{{$designation->designation_id}}">
			            	<i class="fa fa-edit" title="Edit"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-success btn-xs save-update-designation" id="saveUpdate_{{$designation->designation_id}}" style="display: none;">
			            	<i class="fa fa-save" title="Save"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-primary btn-xs reset" id="refresh_{{$designation->designation_id}}" style="display: none;">
			            	<i class="fa fa-refresh fa-spin" title="Reset"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-danger btn-xs" style="@if($designation->status == 2) display: none; @endif" onclick="updateStatus('designation','delete',{{$designation->designation_id}})">
			            	<i class="fa fa-trash" title="Delete"></i>	
			           	</a>
		            </td>
		        </tr>
		        @endforeach
		        @endif
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>Designation Type</th>
		            <th>Designation Name</th>
		            <th>Status</th>
		            <th>Action</th>
		        </tr>
		    </tfoot>
		</table>
    </div>
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$('#designationDatatable').DataTable();
	});

	$('.edit-designation').on('click', function(){

		$(this).parent().prev().prev().prev().children().next().show().prev().hide();
		$(this).parent().prev().prev().children().next().show().prev().hide();
		$(this).hide().next().show().next().show();
	});

	$('.reset').on('click', function(){
		$(this).parent().prev().prev().prev().children().next().hide().prev().show();
		$(this).parent().prev().prev().children().next().hide().prev().show();
		$(this).hide().prev().hide().prev().show();
	});

	$('.save-update-designation').on('click', function(){

		var thisClass 			= $(this);
		var designationId   	= thisClass.attr('id').split('_')[1];
		var designationType 	= $("#designationType_"+designationId);
		var designationTypeText = $("#designationType_"+designationId+" option:selected").text();
		var designationName 	= $("#designationName_"+designationId);
		// alert(designationTypeText);

		$.ajax({
			url	 : "update-save-designation",
			method	 : "GET",
			dataType : "json",
			data : {
				designation_id : designationId,
				designation_type : designationType.val(),
				designation_name : designationName.val(),
			},
			success: function(data){
				if(data.success == true){
					designationType.hide().prev().show().html(designationTypeText);
					designationName.hide().prev().show().html(designationName.val());
					thisClass.hide().prev().show();
		    		$('.box-modal-message').show();
		    		$('.messageBodySuccess').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    	}else{
		    		$('.box-modal-message').show();
		    		$('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    	}
			},
			error: function(data){
				$('.box-modal-message').show();
		    	$('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
			}
		});
	});
	function updateStatus(modelReference,action,id)
	{
		var reference = $("#reference_"+id);
		if(action == 'delete'){
			if(!confirm('Do you want to Delete ?')){
				return false;
			}
		}
		$.ajax({
			url: "update-status/"+modelReference+"/"+action+"/"+id,
		    method: "GET",
		    dataType: 'json',
		    success: function(data){
		    	if(data.success == true){
		    		if(action == 'active'){
			    		reference.prev().show().prev().hide();
			    		reference.parent().prev().children().next().show().prev().hide();
		    		}else if(action == 'inactive'){
		    			reference.prev().hide().prev().show();
		    			reference.parent().prev().children().next().hide().prev().show();
		    		}else if(action == 'delete'){
		    			reference.parent().parent().hide(1000).remove();
		    		}
		    		$('.box-modal-message').show();
		    		$('.messageBodySuccess').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    	}else{
		    		$('.box-modal-message').show();
		    		$('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    	}
		    },
		    error: function(data){
		    	$('.box-modal-message').show();
		    	$('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    }
		});
	}


	$(".modal-title").html('View Designation');

	$('.btn-submit-action').parent().hide();

</script>