
<a href="javascript:;" onclick="updateStatus('diagnostic-test','active',{{$diagnostic->diagnostic_test_id}})" class="btn btn-success btn-xs" @if($diagnostic->status == 1) style="display:none" @endif>
    <i class="fa fa-check-square-o" title="Active"></i>
</a>

<a href="javascript:;" onclick="updateStatus('diagnostic-test','inactive',{{$diagnostic->diagnostic_test_id}})" class="btn btn-warning btn-xs" @if($diagnostic->status == 0) style="display:none" @endif >
    <i class="fa fa-ban" title="Inactive"></i>
</a>

<a id="reference_{{$diagnostic->diagnostic_test_id}}" class="btn btn-info btn-xs" data-toggle="modal" href="#modal" onclick="loadModalEdit('diagnostic/edit-diagnosticTest',{{$diagnostic->diagnostic_test_id}})">
    <i class="fa fa-edit" title="Edit"></i>
</a>

<a href="javascript:;" onclick="updateStatus('diagnostic-test','delete',{{$diagnostic->diagnostic_test_id}})" class="btn btn-danger btn-xs" @if($diagnostic->status == 2) style="display: none;" @endif >
    <i class="fa fa-trash" title="Delete"></i>
</a>