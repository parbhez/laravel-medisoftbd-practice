<div class="row">
    <div class="col-md-12">
        <form action="{{route('settings.save-service-sub-category.post')}}" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" novalidate="true">
            <!-- SmartWizard html -->
            <div class="form-group">
                <div class="col-md-12">
                    <label for="service_category_name" class="col-md-4">
                        Category Name:
                    </label>
                    <div class="col-md-8">
                        {{ Form::select('service_category_name', $serviceCategories, null, ['class' => 'form-control select2', 'id' => 'service_category_name','required' => 'required'] ) }}
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="service_sub_category_name" class="col-md-4">Sub Category Name:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="service_sub_category_name" id="service_sub_category_name" placeholder="Write Sub Category Name" required="">
                        {{csrf_field()}}
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</div>
<script type="text/javascript">

    $(".modal-title").html('Add Service Sub Category');
    $('.btn-submit-action').parent().show();
    $('.btn-submit-action').on('click', function(){
        $("#myForm").submit();
    });

</script>