
<div class="row">
    <div class="col-md-12">
    	<table id="serviceSubCategoryDatatable" class="table table-bordered table-striped">
		    <thead>
		        <tr>
		            <th>Category Name</th>
		            <th>Sub Category Name</th>
		            <th>Status</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		    <tbody>
		    	@if(count($serviceSubCategories) > 0)
		    	@foreach($serviceSubCategories as $key => $serviceSubCategory)
		        <tr>
		            <td>
		            	<span>
		            		{{$serviceSubCategory->serviceCategory->service_category_name}}
		            	</span>
		            	{{ Form::select('category_name', $serviceCategories, $serviceSubCategory->service_category_id,['class' => 'form-control select2', 'id' => 'categoryName_'.$serviceSubCategory->service_sub_category_id,'required' => 'required','style' => 'display:none;'] ) }}
		            </td>
		            <td>
		            	<span>{{$serviceSubCategory->service_sub_category_name}}</span>
		            	<input type="text" name="service_sub_category_name" class="form-control" id="subCategoryName_{{$serviceSubCategory->service_sub_category_id}}" value="{{$serviceSubCategory->service_sub_category_name}}" style="display: none;">
		        	</td>
		            <td>
	            		<label class="label label-warning" style="@if($serviceSubCategory->status == 1) display: none; @endif">
	            			Inactive
	            		</label>
	            		<label class="label label-success"  style="@if($serviceSubCategory->status == 0) display: none; @endif">
	            			Active
	            		</label>
		            </td>
		            <td>
			            <a href="javascript:;" class="btn btn-success btn-xs" style="@if($serviceSubCategory->status == 1) display: none; @endif" onclick="updateStatus('service-sub-category','active',{{$serviceSubCategory->service_sub_category_id}})">
			            	<i class="fa fa-check-square-o" title="Active"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-warning btn-xs" style="@if($serviceSubCategory->status == 0) display: none; @endif" onclick="updateStatus('service-sub-category','inactive',{{$serviceSubCategory->service_sub_category_id}})">
			            	<i class="fa fa-ban" title="Inactive"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-info btn-xs edit-service-sub-category" id="reference_{{$serviceSubCategory->service_sub_category_id}}">
			            	<i class="fa fa-edit" title="Edit"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-success btn-xs save-update-service-sub-category" id="saveUpdate_{{$serviceSubCategory->service_sub_category_id}}" style="display: none;">
			            	<i class="fa fa-save" title="Save"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-primary btn-xs reset" id="refresh_{{$serviceSubCategory->service_sub_category_id}}" style="display: none;">
			            	<i class="fa fa-refresh fa-spin" title="Reset"></i>	
			           	</a>
			           	<a href="javascript:;" class="btn btn-danger btn-xs" style="@if($serviceSubCategory->status == 2) display: none; @endif" onclick="updateStatus('service-sub-category','delete',{{$serviceSubCategory->service_sub_category_id}})">
			            	<i class="fa fa-trash" title="Delete"></i>	
			           	</a>
		            </td>
		        </tr>
		        @endforeach
		        @endif
		    </tbody>
		    <tfoot>
		        <tr>
		            <th>Category Name</th>
		            <th>Sub Category Name</th>
		            <th>Status</th>
		            <th>Action</th>
		        </tr>
		    </tfoot>
		</table>
    </div>
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$('#serviceSubCategoryDatatable').DataTable();
	});

	$('.edit-service-sub-category').on('click', function(){

		$(this).parent().prev().prev().prev().children().next().show().prev().hide();
		$(this).parent().prev().prev().children().next().show().prev().hide();
		$(this).hide().next().show().next().show();
	});

	$('.reset').on('click', function(){
		$(this).parent().prev().prev().prev().children().next().hide().prev().show();
		$(this).parent().prev().prev().children().next().hide().prev().show();
		$(this).hide().prev().hide().prev().show();
	});

	$('.save-update-service-sub-category').on('click', function(){

		var thisClass 			= $(this);
		var serviceSubCategoryId   	= thisClass.attr('id').split('_')[1];
		var categoryName 	= $("#categoryName_"+serviceSubCategoryId);
		var categoryNameText = $("#categoryName_"+serviceSubCategoryId+" option:selected").text();
		var subCategoryName 	= $("#subCategoryName_"+serviceSubCategoryId);
		// alert(categoryNameText);

		$.ajax({
			url	 : "update-save-service-sub-category",
			method	 : "GET",
			dataType : "json",
			data : {
				service_sub_category_id : serviceSubCategoryId,
				service_category_name : categoryName.val(),
				service_sub_category_name : subCategoryName.val(),
			},
			success: function(data){
				if(data.success == true){
					categoryName.hide().prev().show().html(categoryNameText);
					subCategoryName.hide().prev().show().html(subCategoryName.val());
					thisClass.hide().prev().show().next().next().hide();
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


	$(".modal-title").html('View Service Sub Category');

	$('.btn-submit-action').parent().hide();

</script>