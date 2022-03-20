@extends('app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Diagnostic Test Sale Reports
        <small>Preview</small>
      </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Reports</a></li>
        <li class="active">Diagnostic Test Sale Reports</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
	<!-- Custom Tabs -->
	<div class="nav-tabs-custom">
		<form name="searchForm" class="searchForm form-horizontal" method="post" action="{{route('reports.getDiagnosticTestSaleReport.post')}}">
			<div class="row">
				<div class="form-group" style="margin-top: 10px; margin-bottom: 5px;">
					<div class="col-md-9 col-md-offset-3">
						<label class="col-md-1"> 
							<i class="fa fa-calendar"></i>
							From: 
						</label>
			    		<div class="col-md-3">
			    			{{csrf_field()}}
				    		<input class="form-control datepicker" autocomplete="off" type="text" name="from" id="from" value="{{$from}}">
			    			
			    		</div>
			    		<label class="col-md-1"> 
			    			<i class="fa fa-calendar"></i>
			    			To: 
			    		</label>
			    		<div class="col-md-3">
				    		 <input class="form-control datepicker" autocomplete="off" type="text" name="to" id="to" value="{{$to}}">
			    		</div>
			    		<div class="col-md-2">
				    		<button class="btn btn-sm btn-primary" type="submit"> Submit </button>
			    		</div>
				    </div>
				</div>
		    </div>
		</form>
	    
	    <div class="tab-content">
	        <div class="tab-pane active" id="view-employee">
	        	<div class="box box-default">
		        	<div class="box-body">
			            <div class="row">
			                <div class="col-md-12">
			                	<table id="testSaleReportDatatable" class="table table-bordered table-striped">
								    <thead>
								        <tr>
								            <th>Invoice ID</th>
								            <th>Discount</th>
								            <th>Total</th>
								            <th>Paid</th>
								            <th>Due</th>
								            <th>Date</th>
								            <th>Status</th>
								            <th>Action</th>
								        </tr>
								    </thead>
								    
								    <tfoot>
								        <tr>
								            <th>Invoice ID</th>
								            <th>Discount</th>
								            <th>Total</th>
								            <th>Paid</th>
								            <th>Due</th>
								            <th>Date</th>
								            <th>Status</th>
								            <th>Action</th>
								        </tr>
								    </tfoot>
								</table>
			                </div>
			            </div>
			        </div>
			        <div class="box-footer">
			            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about the plugin.
			        </div>
		    	</div>
	        </div>
	        <!-- /.tab-pane -->
	    </div>
	    <!-- /.tab-content -->
	</div>
	<!-- nav-tabs-custom -->
	<!-- SELECT2 EXAMPLE -->
        
</section>
<!-- Normal Modal -->
<div id="saleReportModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content"  style="width: 800px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Diagnostic Test Sale Report</h4>
            </div>
            <!-- //Message from Ajax request// -->
            <div class="modal-body" id="saleDetailsBody">
                Loading <img src="{{url('public/icons/loader.gif')}}" title="loading">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> <!-- /.modal -->

@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function () {
			var fromDate = $("#from").val();
			var toDate = $("#to").val();
            $('#testSaleReportDatatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                'order': [[0, "asc"]],
                ajax: "{{ URL::to('reports/get-diagnostic-test-sale-report')}}/"+fromDate+"/"+toDate,
                columns: [
                    {data: 'invoice_id', name: 'invoice_id', orderable: true, searchable: true},
                    {data: 'discount', name: 'discount', orderable: true, searchable: true},
                    {data: 'total', name: 'total', orderable: true, searchable: true},
                    {data: 'paid', name: 'paid', orderable: true, searchable: true},
                    {data: 'due',name: 'due',orderable: true,searchable: true},
                    {data: 'date',name: 'date',orderable: true,searchable: true},
                    {data: 'status', name: 'status', orderable: true, searchable: false},
                    {data: 'action', name: 'action', orderable: true, searchable: false},
                ]
            });
        });


	function loadingImg(){
		$('#loading').ajaxStart(function() {
			$(this).show();
		}).ajaxComplete(function() {
			$(this).hide();
		});
	}


	function saleDetails(saleInvoiceId){
		$(function(){		
			loadingImg();							
			$("#saleDetailsBody").load("{{url('reports/sale-report-details')}}"+"/"+saleInvoiceId);
		});
	}

	function updateStatus(action,url,id)
	{
		var reference = $("#reference_"+id);
		if(action == 'delete'){
			if(!confirm('Do you want to Delete ?')){
				return false;
			}
		}

		$.ajax({
			url: "update-"+url+'-status/'+action+'/'+id,
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
		    		
		    		$('.box-body-second').show();
		    		$('.messageBodySuccess').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    	}else{
		    		$('.box-body-second').show();
		    		$('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    	}
		    },
		    error: function(data){
		    	$('.box-body-second').show();
		    	$('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(data.message);
		    }
		});
	}

</script>
@endsection