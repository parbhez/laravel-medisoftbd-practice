@extends('app')
@section('content')
<style type="text/css">
	

</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Reports
        <small>Preview</small>
      </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Reports</a></li>
        <li class="active">Reports</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
	<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">

	            	<div class="col-md-4">
	                	<div class="box box-info box-solid ">
				            <div class="box-header with-border">
				              <h3 class="box-title">Details Reports</h3>
				              <div class="box-tools pull-right">
				                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
				                </button>
				              </div>
				              <!-- /.box-tools -->
				            </div>
				            <!-- /.box-header -->
				            <div class="box-body" style="">

				            	<div class="col-md-4 overlay-icons-body">
							        <div class="box box-danger box-solid">
							            <div class="box-body">
							            	<i class="fa fa-edit overlay-icons"></i>
							            	<br> <span> Diagnostic Test  </span>
							            </div>
							            <!-- /.box-body -->
							            <!-- Loading (remove the following to stop the loading)-->
							            <div class="overlay">
							            	<div class="buttons" >
							            		<a class="btn btn-default" href="{{route('reports.diagnostic-test-report')}}" style=" margin-top: 35px;">
							            			<i class="fa fa-search-plus"></i>
							            			&nbsp;View
							            		</a>
							            	</div>
							            </div>
							            <!-- end loading -->
							        </div>
							          <!-- /.box -->
							    </div>
							    <div class="col-md-4 overlay-icons-body">
							        <div class="box box-danger box-solid">
							            <div class="box-body">
							            	<i class="fa fa-edit overlay-icons"></i>
							            	<br> <span> Department </span>
							            	
							            </div>
							            <!-- /.box-body -->
							            <!-- Loading (remove the following to stop the loading)-->
							            <div class="overlay">
							            	<div class="buttons" >
							            		<a class="btn btn-default" data-toggle="modal" href="#modal" onclick="loadModal('settings/view-department')" style="    margin-top: 35px;">
							            			<i class="fa fa-search-plus"></i>
							            			&nbsp;View
							            		</a>
							            	</div>

							            </div>
							            <!-- end loading -->
							        </div>
							          <!-- /.box -->
							    </div>
							    <div class="col-md-4 overlay-icons-body">
							        <div class="box box-danger box-solid">
							            <div class="box-body">
							            	<i class="fa fa-edit overlay-icons"></i>
							            	<br> <span> Education Qualification </span>
							            	
							            </div>
							            <!-- /.box-body -->
							            <!-- Loading (remove the following to stop the loading)-->
							            <div class="overlay">
							            	<div class="buttons" >
							            		<a class="btn btn-default" data-toggle="modal" href="#modal" onclick="loadModal('settings/view-educational-qualification')" style="    margin-top: 35px;">
							            			<i class="fa fa-search-plus"></i>
							            			&nbsp;View
							            		</a>
							            	</div>

							            </div>
							            <!-- end loading -->
							        </div>
							          <!-- /.box -->
							    </div>
							    <div class="col-md-4 overlay-icons-body">
							        <div class="box box-danger box-solid">
							            <div class="box-body">
							            	<i class="fa fa-edit overlay-icons"></i>
							            	<br> <span> Medical Degree </span>
							            </div>
							            <!-- /.box-body -->
							            <!-- Loading (remove the following to stop the loading)-->
							            <div class="overlay">
							            	<div class="buttons" >
							            		<a class="btn btn-default" data-toggle="modal" href="#modal" onclick="loadModal('settings/view-medical-degree')" style="    margin-top: 35px;">
							            			<i class="fa fa-search-plus"></i>
							            			&nbsp;View
							            		</a>
							            	</div>

							            </div>
							            <!-- end loading -->
							        </div>
							          <!-- /.box -->
							    </div>
				            </div>
			            <!-- /.box-body -->
			          	</div>
			        </div>

			        <div class="col-md-4">
	                	<div class="box box-info box-solid ">
				            <div class="box-header with-border">
				              <h3 class="box-title">Graphical Reports</h3>
				              <div class="box-tools pull-right">
				                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
				                </button>
				              </div>
				              <!-- /.box-tools -->
				            </div>
				            <!-- /.box-header -->
				            <div class="box-body" style="">
				            </div>
			            <!-- /.box-body -->
			          	</div>
			        </div>
                </div>
            </div>
        </div>
</section>

@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){

	});
</script>
@endsection