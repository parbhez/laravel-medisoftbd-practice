    
<div class="row">
    <div class="col-md-12">
        <form action="{{route('settings.save-educational-qualification.post')}}" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" novalidate="true">
            <!-- SmartWizard html -->
            <div class="form-group">
                <div class="col-md-12">
                    <label for="educational_qualification_name" class="col-md-4"> Qualification Name:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="educational_qualification_name[]" id="educational_qualification_name" placeholder="Write Educational Qualification Name" required="">
                        {{csrf_field()}}
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-1">
                        <a href="javascript:;" class="btn btn-success btn-add-row">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

	$(".modal-title").html('Add Educational Qualification');
    $('.btn-submit-action').parent().show();

	$('.btn-submit-action').on('click', function(){
		$("#myForm").submit();
	});

    $(document).ready(function(){
        $(".btn-add-row").on('click', function(){
            var content = '<div class="form-group">'+
                            '<div class="col-md-12">'+
                                '<label for="educational_qualification_name" class="col-md-4"> Qualification Name:</label>'+
                                '<div class="col-md-7">'+
                                    '<input type="text" class="form-control" name="educational_qualification_name[]" id="educational_qualification_name" placeholder="Write Educational Qualification Name" required="">'+
                                    '<div class="help-block with-errors"></div>'+
                                '</div>'+
                                '<div class="col-md-1">'+
                                    '<a href="javascript:;" class="btn btn-danger btn-remove-row">'+
                                        '<i class="fa fa-minus"></i>'+
                                    '</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
            $("#myForm").append(content);

            $('.btn-remove-row').on('click',function(){
                $(this).parent().parent().parent().remove();
            }); 
        });
    });

</script>