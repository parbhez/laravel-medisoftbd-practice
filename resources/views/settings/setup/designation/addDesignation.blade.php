    
<div class="row">
    <div class="col-md-12">
        <form action="{{route('settings.save-designation.post')}}" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" novalidate="true">
            <!-- SmartWizard html -->
            <div class="form-group">
                <div class="col-md-12">
                    <label for="designation_name" class="col-md-4">Designation Name:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="designation_name" id="designation_name" placeholder="Write Designation Name" required="">
                        {{csrf_field()}}
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="designation_name" class="col-md-4">
                    	Designation Type:
                	</label>
                    <div class="col-md-8">
                        <select name="designation_type" id="designation_name" class="form-control" required="">
                        	<option selected="" disabled=""> 
                        		Select a Designation Type
                        	</option>
                        	<option value="1"> 
                        		Employee Designation
                        	</option>
                        	<option value="2"> 
                        		Doctor Designation
                        	</option>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

	$(".modal-title").html('Add Designation');
    $('.btn-submit-action').parent().show();

	$('.btn-submit-action').on('click', function(){
		$("#myForm").submit();
	});

</script>