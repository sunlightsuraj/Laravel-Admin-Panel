<?php
/**
 * User: suraj
 * Date: 4/7/17
 * Time: 4:43 PM
 */
?>

<section class="content-header">
	<a href="#" data-toggle="modal" data-target="#add-category-modal" class="btn btn-primary btn-sm pull-right">Add Category</a>
	<h1>
		Category
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
			<th>Featured Image</th>
			<th>Description</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@if($categories)
			@php
			$i = 0;
			@endphp
			@foreach($categories as $category)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $category->category_title }}</td>
					<td>
						@if($category->featured_image != '')
							<img src="{{ url('uploads/category/' . $category->featured_image) }}"
							     alt="{{ $category->category_title }}"
							     class="img-responsive" style="width: 150px">
						@endif
					</td>
					<td>{{ $category->category_description }}</td>
					<td>
						<div class="dropdown">
							<a href="#" class="btn btn-primary btn-sm" data-toggle="dropdown">Action <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#" class="edit-category" data-cid="{{ $category->id }}" data-ct="{{ $category->category_title }}" data-cd="{{ $category->category_description }}"><i class="fa fa-pencil"></i> Edit</a></li>
								<li><a href="{{ route('admin_category_delete', $category->id) }}" onclick="return window.confirm('Are you sure? You want to delete this category.');"><i class="fa fa-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>
	<!-- Your Page Content Here -->
</section>
<div class="modal" id="add-category-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add Category</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_category_add') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="category-title-input" class="text-info">Title</label>
						<input type="text" class="form-control" id="category-title-input" name="title"
						       placeholder="Category Title">
					</div>
					<div class="form-group">
						<label for="featured-image-input" class="text-info">Featured Image</label>
						<input type="file" class="form-control" id="featured-image-input" name="featured_image"
						       title="Featured Image">
					</div>
					<div class="form-group">
						<label for="description-input" class="text-info">Description</label>
						<textarea name="description" id="description-input" cols="30" rows="10" class="form-control"
						          placeholder="Description"></textarea>
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
<div class="modal" id="edit-category-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add Category</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_category_edit') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" id="cid" name="cid" value="0">
					<div class="form-group">
						<label for="category-title-edit-input" class="text-info">Title</label>
						<input type="text" class="form-control" id="category-title-edit-input" name="title"
						       placeholder="Category Title">
					</div>
					<div class="form-group">
						<label for="featured-image-edit-input" class="text-info">Featured Image</label>
						<input type="file" class="form-control" id="featured-image-edit-input" name="featured_image"
						       title="Featured Image">
					</div>
					<div class="form-group">
						<label for="description-edit-input" class="text-info">Description</label>
						<textarea name="description" id="description-edit-input" cols="30" rows="10" class="form-control"
						          placeholder="Description"></textarea>
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

@push('scripts')
<script type="text/javascript">
	$(document).ready(function () {
		$(".edit-category").click(function (event) {
			event.preventDefault();
			var t = $(this);
			var cid = t.data('cid');
			var ct = t.data('ct');
			var cd = t.data('cd');

			$("#cid").val(cid);
			$("#category-title-edit-input").val(ct);
			$("#description-edit-input").val(cd);

			$("#edit-category-modal").modal('show');
		});
	});
</script>
@endpush