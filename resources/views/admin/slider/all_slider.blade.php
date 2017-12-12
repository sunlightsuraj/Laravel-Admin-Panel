<?php
/**
 * User: suraj
 * Date: 4/7/17
 * Time: 5:16 PM
 */
?>

<section class="content-header">
	<a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#add-slider-modal">Add Slider</a>
	<h1>
		Slider
	</h1>
	{{--<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
		<li class="active">Dashboard</li>
	</ol>--}}
</section>

<!-- Main content -->
<section class="content">
	@if(session('message'))
		<div class="alert alert-info alert-dismissible">
			<button class="close" data-dismiss="alert">&times;</button>
			{!! session('message') !!}
		</div>
	@endif
	<table class="table table-responsive table-hover">
		<thead>
		<tr>
			<th>S.N</th>
			<th>Image</th>
			<th>Title</th>
			<th>Caption</th>
			<th>Position</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		@if($sliders)
			@php
			$i = 0;
			@endphp
			@foreach($sliders as $slider)
				<tr>
					<td>{{ ++$i }}</td>
					<td>
						@if($slider->slider_image != '')
							<img src="{{ url('uploads/slider/' . $slider->slider_image) }}"
							     alt="{{ $slider->slider_image }}"
							     class="img-responsive" style="width: 100px">
						@endif
					</td>
					<td>{{ $slider->slider_title }}</td>
					<td>{{ $slider->slider_caption }}</td>
					<td>{{ $slider->position }}</td>
					<td>
						<div class="dropdown">
							<a href="#" class="btn btn-primary btn-sm" data-toggle="dropdown">
								Action <i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('admin_slider_edit', [$slider->id]) }}" class="edit-slider"><i class="fa fa-pencil"></i> Edit</a></li>
								<li><a href="{{ route('admin_slider_delete', [$slider->id]) }}" onclick="return window.confirm('Are you sure? You want to delete this slider.');"><i class="fa fa-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>
</section>
<div class="modal" id="add-slider-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add Slider</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_slider_add') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="slider-image-input" class="text-info">Slider Image</label>
						<input type="file" class="form-control" id="slider-image-input" name="slider_image"
						       title="Slider Image" required>
					</div>
					<div class="form-group">
						<label for="slider-title-input" class="text-info">Title</label>
						<input type="text" class="form-control" id="slider-title-input" name="title"
						       placeholder="Title">
					</div>
					<div class="form-group">
						<label for="slider-caption-input" class="text-info">Caption</label>
						<textarea name="caption" id="slider-caption-input" cols="10" rows="5" class="form-control"
						          placeholder="Caption"></textarea>
					</div>
					<div class="form-group">
						<label for="position-input" class="text-info">Position</label>
						<input type="number" class="form-control" id="position-input" name="position"
						       placeholder="Position" min="0">
					</div>
					<p class="text-warning error small"></p>
					<div class="form-group">
						<button class="btn btn-success pull-right" type="submit">Add</button>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="edit-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">
					Edit Slider
				</h3>
			</div>
			<div class="modal-body">
				<p style="display: table;margin: auto;"><i class="fa fa-spinner fa-pulse fa-spin fa-5x"></i></p>
			</div>
		</div>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	$(document).ready(function () {
		$(".edit-slider").click(function (event) {
			event.preventDefault();
			var t = $(this);
			var url = t.attr('href');
			var em = $("#edit-modal");
			em.modal('show');
			$.get(url, function (response) {
				em.find('.modal-body').html(response);
			})
					.fail(function () {
						em.find(".modal-body").html('<p class="text-warning">Request Failed.</p>');
					});
		});
		$("#edit-modal").on('hidden.bs.modal', function () {
			$(this).find('.modal-body').html('<p style="display: table;margin: auto;"><i class="fa fa-spinner fa-pulse fa-spin fa-5x"></i></p>');
		});
	});
</script>
@endpush