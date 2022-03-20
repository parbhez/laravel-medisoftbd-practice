@include('_partials.top')
@include('_partials.header')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@yield('content-header')

		@include('common.message')

		@yield('content')
	</div>

@include('common.modal')
@include('_partials.footer')

	@yield('script')

@include('_partials.bottom')