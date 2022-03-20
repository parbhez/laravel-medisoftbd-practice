<script>
    function loadModal(url) {
        var baseUrl = '<?php echo URL::to(''); ?>';
        $("#body-content").load(baseUrl + "/" + url);
    }

    function loadModalEdit(url, id) {
        var baseUrl = '<?php echo URL::to(''); ?>';
        $("#body-content").load(baseUrl + "/" + url + "/" + id);
    }
</script>
<!-- Normal Modal -->
<div id="modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <!-- //Message from Ajax request// -->
            <div class="box-body box-modal-message" style="display: none;">
                <div class="alert alert-success alert-dismissible messageBodySuccess" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span></span>
                </div>
                <div class="alert alert-warning alert-dismissible messageBodyError" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span></span>
                </div>
            </div>

            <div class="modal-body" id="body-content">
                Loading <img src="{{url('public/icons/loader.gif')}}" title="loading">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success pull-right btn-submit-action"> Save</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> <!-- /.modal -->