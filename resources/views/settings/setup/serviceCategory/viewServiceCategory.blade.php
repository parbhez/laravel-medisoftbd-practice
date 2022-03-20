
<div class="row">
    <div class="col-md-12">
    	<table id="departmentDatatable" class="table table-bordered table-striped">
		    <thead>
		        <tr>
		            <th>Category Name</th>
		            <th>Status</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		    <tbody>
		    	@if(count($serviceCategories) > 0)
		    	@foreach($serviceCategories as $key => $serviceCategory)
		        <tr>
		            <td>
		            	<span>{{$serviceCategory->service_category_name}}</span>
		            	<input type="text" name="service_category_name" class="form-control" id="serviceCategoryName_{{$serviceCategory->service_category_id}}" value="{{$serviceCategory->service_category_name}}" style="display: none;">
		        	</td>
		            <td>
	            		<label class="label label-warning" style="@if($serviceCategory->status == 1) display: none; @endif">
	            			Inactive
	            		</label>
	            		<label class="label label-success"  style="@if($serviceCategory->status == 0) display: none; @endif">
	            			Active
	            		</label>
		            </td>
		            <td>
			            <a href="javascript:;" class="btn btn-success btn-xs" style="@if($serviceCategory->status == 1) display: none; @endif" onclick="updateStatus('service-category','active',{{$serviceCategory->service_category_id}})">
			            	<i class="fa fa-check-square-o" title="Active"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-warning btn-xs" style="@if($serviceCategory->status == 0) display: none; @endif" onclick="updateStatus('service-category','inactive',{{$serviceCategory->service_category_id}})">
			            	<i class="fa fa-ban" title="Inactive"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-info btn-xs edit-service-category" id="reference_{{$serviceCategory->service_category_id}}">
			            	<i class="fa fa-edit" title="Edit"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-success btn-xs save-update-service-category" id="saveUpdate_{{$serviceCategory->service_category_id}}" style="display: none;">
			            	<i class="fa fa-save" title="Save"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-primary btn-xs reset" id="refresh_{{$serviceCategory->service_category_id}}" style="display: none;">
			            	<i class="fa fa-refresh fa-spin" title="Reset"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-danger btn-xs" style="@if($serviceCategory->status == 2) display: none; @endif" onclick="updateStatus('service-category','delete',{{$serviceCategory->service_category_id}})">
			            	<i class="fa fa-trash" title="Delete"></i>	
			           	</a>
		            </td>
		        </tr>
		        @endforeach
		        @endif
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>Department Name</th>
		            <th>Status</th>
		            <th>Action</th>
		        </tr>
		    </tfoot>
		</table>
    </div>
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$('#departmentDatatable').DataTable();
	});

	$('.edit-service-category').on('click', function(){
		$(this).parent().prev().prev().children().next().show().prev().hide();
		$(this).hide().next().show().next().show();
	});

	$('.reset').on('click', function(){
		$(this).parent().prev().prev().children().next().hide().prev().show();
		$(this).hide().prev().hide().prev().show();
	});

	$('.save-update-service-category').on('click', function(){

		var thisClass 			= $(this);
		var serviceCategoryId   	= thisClass.attr('id').split('_')[1];
		var serviceCategoryName 	= $("#serviceCategoryName_"+serviceCategoryId);
		// alert(serviceCategoryTypeText);

		$.ajax({
			url	 : "update-save-service-category",
			method	 : "GET",
			dataType : "json",
			data : {
				service_category_id : serviceCategoryId,
				service_category_name : serviceCategoryName.val(),
			},
			success: function(data){
				if(data.success == true){
					serviceCategoryName.hide().prev().show().html(serviceCategoryName.val());
					thisClass.hide().prev().show().next().next().hide();
		    		$('.box-modal-message').show();
		    		$('.messageBodySuccess').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    	}else{
					alert('error');
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


	$(".modal-title").html('View serviceCategory');

	$('.btn-submit-action').parent().hide();

</script>