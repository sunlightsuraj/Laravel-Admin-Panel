<?php
/**
 * User: suraj
 * Date: 4/7/17
 * Time: 1:47 PM
 */
?>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Dashboard
	</h1>
	{{--<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
		<li class="active">Dashboard</li>
	</ol>--}}
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-red"><i class="fa fa-picture-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_slider')}}">Sliders</a></a></span>
					<span class="info-box-number">{{ $sliders_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>

		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-picture-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_category')}}">Category</a></span>
					<span class="info-box-number">{{ $category_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-blue"><i class="fa fa-picture-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_product')}}">Product</a></span>
					<span class="info-box-number">{{ $product_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-red"><i class="fa fa-picture-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_service')}}">Service</a></span>
					<span class="info-box-number">{{ $service_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>

		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-bars"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_menu')}}">Menu</a></span>
					<span class="info-box-number">{{ $menu_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-blue"><i class="fa fa-file-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_pages')}}">Page</a></span>
					<span class="info-box-number">{{ $page_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-red"><i class="fa fa-picture-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_testimonials')}}">Testimonial</a></span>
					<span class="info-box-number">{{ $testimonial_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>

		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-download "></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_download')}}">Download</a></span>
					<span class="info-box-number">{{ $download_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-blue"><i class="fa fa-newspaper-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_news')}}">News</a></span>
					<span class="info-box-number">{{ $news_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-red"><i class="fa fa-envelope-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><a href="{{route('admin_contact_messages')}}">Contact Message</a></span>
					<span class="info-box-number">{{ $message_count }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</div>

		@if(session('super_user'))
			<div class="col-sm-6 col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

					<div class="info-box-content">
						<span class="info-box-text"><a href="{{ route('admin_users') }}">Users</a></span>
						<span class="info-box-number">{{ $users_count }}</span>
					</div>

				</div>
			</div>
		@endif

		{{--<div class="col-sm-6 col-md-4">
			<div class="info-box">
				<span class="info-box-icon bg-blue"><i class="fa fa-picture-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Page</span>
					<span class="info-box-number">{{ $page_count }}</span>
				</div>
				
			</div>
		</div>--}}

	</div>

</section>
<!-- /.content -->
