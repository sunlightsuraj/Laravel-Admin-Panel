<?php
/**
 * User: suraj
 * Date: 4/9/17
 * Time: 12:52 PM
 */
?>

<section class="content-header">
	<a href="{{ route('admin_page_add') }}" class="btn btn-primary btn-sm pull-right">Add Page</a>
	<h1>
		Pages
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
	<table class="table table-hover table-responsive">
		<thead>
		<tr>
			<th>S.N</th>
			<th>Title</th>
			<th>Featured Image</th>
			<th>Public Link</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		@if($pages)
			@php
			$i = 0;
			@endphp
			@foreach($pages as $page)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $page->title }}</td>
					<td>
						@if($page->image != '')
							<img src="{{ url('uploads/page/' . $page->image) }}" alt="{{ $page->image }}" style="width: 150px;">
						@endif
					</td>
					<td><a href="{{ route('page', $page->slug) }}" target="_blank">{{ route('page', $page->slug) }}</a> </td>
					<td>
						<div class="dropdown">
							<a href="#" class="btn btn-primary btn-sm" data-toggle="dropdown">Action <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('admin_page_edit', [$page->id]) }}"><i class="fa fa-pencil"></i> Edit</a></li>
								<li><a href="{{ route('admin_page_delete', [$page->id]) }}" onclick="return window.confirm('Are you sure? You want to delete this page.');"><i class="fa fa-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>
</section>
