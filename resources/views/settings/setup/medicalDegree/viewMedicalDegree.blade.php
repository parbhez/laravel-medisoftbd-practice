
<div class="row">
    <div class="col-md-12">
    	<table id="designationDatatable" class="table table-bordered table-striped">
		    <thead>
		        <tr>
		            <th>Degree Name</th>
		            <th>Status</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		    <tbody>
		    	@if(count($medicalDegrees) > 0)
		    	@foreach($medicalDegrees as $key => $medicalDegree)
		        <tr>
		            <td>
		            	<span>{{$medicalDegree->medical_degree_name}}</span>
		            	<input type="text" name="medical_degree_name" class="form-control" id="medicalDegreeName_{{$medicalDegree->medical_degree_id}}" value="{{$medicalDegree->medical_degree_name}}" style="display: none;">
		        	</td>
		            <td>
	            		<label class="label label-warning" style="@if($medicalDegree->status == 1) display: none; @endif">
	            			Inactive
	            		</label>
	            		<label class="label label-success"  style="@if($medicalDegree->status == 0) display: none; @endif">
	            			Active
	            		</label>
		            </td>
		            <td>
			            <a href="javascript:;" class="btn btn-success btn-xs" style="@if($medicalDegree->status == 1) display: none; @endif" onclick="updateStatus('medical-degree','active',{{$medicalDegree->medical_degree_id}})">
			            	<i class="fa fa-check-square-o" title="Active"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-warning btn-xs" style="@if($medicalDegree->status == 0) display: none; @endif" onclick="updateStatus('medical-degree','inactive',{{$medicalDegree->medical_degree_id}})">
			            	<i class="fa fa-ban" title="Inactive"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-info btn-xs edit-medical-degree" id="reference_{{$medicalDegree->medical_degree_id}}">
			            	<i class="fa fa-edit" title="Edit"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-success btn-xs save-update-medical-degree" id="saveUpdate_{{$medicalDegree->medical_degree_id}}" style="display: none;">
			            	<i class="fa fa-save" title="Save"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-primary btn-xs reset" id="refresh_{{$medicalDegree->medical_degree_id}}" style="display: none;">
			            	<i class="fa fa-refresh fa-spin" title="Reset"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-danger btn-xs" style="@if($medicalDegree->status == 2) display: none; @endif" onclick="updateStatus('medical-degree','delete',{{$medicalDegree->medical_degree_id}})">
			            	<i class="fa fa-trash" title="Delete"></i>	
			           	</a>
		            </td>
		        </tr>
		        @endforeach
		        @endif
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>Degree Name</th>
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

	$('.edit-medical-degree').on('click', function(){

		$(this).parent().prev().prev().prev().children().next().show().prev().hide();
		$(this).parent().prev().prev().children().next().show().prev().hide();
		$(this).hide().next().show().next().show();
	});

	$('.reset').on('click', function(){
		$(this).parent().prev().prev().children().next().hide().prev().show();
		$(this).hide().prev().hide().prev().show();
	});

	$('.save-update-medical-degree').on('click', function(){

		var thisClass 			= $(this);
		var medicalDegreeId   	= thisClass.attr('id').split('_')[1];
		var medicalDegreeName 	= $("#medicalDegreeName_"+medicalDegreeId);
		// alert(designationTypeText);

		$.ajax({
			url	 : "update-save-medical-degree",
			method	 : "GET",
			dataType : "json",
			data : {
				medical_degree_id : medicalDegreeId,
				medical_degree_name : medicalDegreeName.val(),
			},
			success: function(data){
				if(data.success == true){
					medicalDegreeName.hide().prev().show().html(medicalDegreeName.val());
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
		    			// reference.
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


	$(".modal-title").html('View Medical Degree');

	$('.btn-submit-action').parent().hide();

</script>