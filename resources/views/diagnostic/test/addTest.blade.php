
    <!-- Main content -->
    <!-- SELECT2 EXAMPLE -->

    <div class="row">
        <div class="col-md-12">
            <form action="{{route('save-diagnosticTest.post')}}" id="myForm"
                  method="post" accept-charset="utf-8">
                <!-- SmartWizard html -->

                {{csrf_field()}}

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="diagnostic_test_name" class="col-md-4">Diagnostic test Name:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="diagnostic_test_name"
                                   id="diagnostic_test_name"
                                   placeholder="Test Name" required="">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="diagnostic_test_price" class="col-md-4">Diagnostic test Price:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="diagnostic_test_price"
                                   id="diagnostic_test_price"
                                   placeholder="Test Price" required="">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="diagnostic_test_price" class="col-md-4">Diagnostic test Sale Price:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="diagnostic_test_sale_price"
                                   id="diagnostic_test_price"
                                   placeholder="Test Sale Price" required="">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">

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
        
        $('.btn-submit-action').on('click', function(){
            $("#myForm").submit();
        });
    </script>

