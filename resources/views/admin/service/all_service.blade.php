<?php
/**
 * User: suraj
 * Date: 4/7/17
 * Time: 5:03 PM
 */
?>

<section class="content-header">
	<a href="{{ route('admin_service_add') }}" {{--data-toggle="modal" data-target="#add-service-modal"--}} class="btn btn-primary btn-sm pull-right">Add Service</a>
	<h1>
		Service
	</h1>
	{{--<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
		<li class="active">Category</li>
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
	<table class="table table-hover table-responsive table-stripped">
		<thead>
		<tr>
			<th>S.N</th>
			<th>Title</th>
			<th>Parent Service</th>
			{{--<th>Linked Page</th>--}}
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		@if($services)
			@php
				$i = 0;
			@endphp
			@foreach($services as $service)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $service->service_title }}</td>
					<td>
						{{ $service->parent ? $service->parent->service_title : '' }}
					</td>
					{{--<td>
						@if($service->page_id && $pages && $pages->where('id', $service->page_id))
							<a href="{{ route('admin_page_edit', [$service->page_id]) }}">{{ $pages->where('id', $service->page_id)->first()->title }}</a>
						@endif
					</td>--}}
					<td width="30%">
						<div class="dropdown" style="display: inline;">
							<a href="#" class="btn btn-primary btn-sm" data-toggle="dropdown">Action <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('admin_service_edit', [$service->id]) }}" class="edit-service"><i class="fa fa-pencil"></i> Edit</a></li>
								<li><a href="{{ route('admin_service_delete', [$service->id]) }}" onclick="return window.confirm('Are you sure? You want to delete this service.');"><i class="fa fa-trash"></i> Delete</a></li>
							</ul>
						</div>
						<a href="{{ route('admin_service_make_featured', [$service->id]) }}" data-t="{{ $service->featured ? 'r' : 'a' }}" class="btn btn-primary btn-sm">{{ $service->featured ? 'Remove featured' : 'Make featured' }}</a>
						{{--<a href="#" class="btn btn-primary btn-sm">Add on slider</a>--}}
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>
	<!-- Your Page Content Here -->
</section>
<div class="modal" id="add-service-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add Service</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_service_add') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="parent-input" class="text-info">Parent service</label>
						<select name="parent" id="parent-input" class="form-control"
						        title="Select parent service">
							<option value="">Select parent service</option>
							@if($services->where('parent_id', 0))
								@foreach($services->where('parent_id', 0) as $service)
									<option value="{{ $service->id }}">{{ $service->service_title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group">
						<label for="service-title-input" class="text-info">Title</label>
						<input type="text" class="form-control" id="service-title-input" name="title"
						       placeholder="Service Title">
					</div>
					<div class="form-group">
						<label for="description-input" class="text-info">Description</label>
						<textarea name="description" id="description-input" cols="30" rows="10" class="form-control"
						          placeholder="Description"></textarea>
					</div>
					<div class="form-group">
						<label for="pages-list" class="text-info">Select content page</label>
						<select name="page" id="pages-list" class="form-control" title="Pages">
							<option value="">Select content page</option>
							@if($pages)
								@foreach($pages as $page)
									<option value="{{ $page->id }}">{{ $page->title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group">
						<button class="btn btn-success pull-right" type="submit">Add</button>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="edit-service-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add Service</h3>
			</div>
			<div class="modal-body">
				<p style="display: block;margin: auto;"><i class="fa fa-spinner fa-pulse fa-spin fa-5x"></i></p>
			</div>
		</div>
	</div>
</div>

{{--
@push('scripts')
<script type="text/javascript">
	$(document).ready(function () {
		$(".edit-service").click(function (event) {
			event.preventDefault();
			var t = $(this);
			var url = t.attr('href');
			var em = $("#edit-service-modal");
			em.modal('show');
			$.get(url, function (response) {
				em.find('.modal-body').html(response);
			})
					.fail(function () {
						em.find(".modal-body").html('<p class="text-warning">Request Failed.</p>');
					});
		});
		$("#edit-service-modal").on('hidden.bs.modal', function () {
			$(this).find('.modal-body').html('<p style="display: table;margin: auto;"><i class="fa fa-spinner fa-pulse fa-spin fa-5x"></i></p>');
		});
	});
</script>
@endpush--}}
