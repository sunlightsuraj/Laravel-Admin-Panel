<?php
/**
 * User: suraj
 * Date: 4/11/17
 * Time: 1:50 PM
 */
?>

<section class="content-header">
	<a href="{{ route('admin_news_add') }}" class="btn btn-primary pull-right">Add News</a>
	<h1>
		News
	</h1>
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
			<th>Thumbnail</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		@if($news)
			@php
			$i = 0;
			@endphp
			@foreach($news as $nn)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $nn->title }}</td>
					<td>
						@if($nn->thumbnail_image)
							<img src="{{ url('uploads/news/' . $nn->thumbnail_image) }}"
							     alt="{{ $nn->thumbnail_image }}" style="width: 200px;">
						@endif
					</td>
					<td>
						<div class="dropdown">
							<a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm">Action <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('admin_news_edit', [$nn->id]) }}"><i class="fa fa-pencil"></i> Edit</a></li>
								<li><a href="{{ route('admin_news_delete', [$nn->id]) }}" onclick="return window.confirm('Are you sure? You want to delete this news.');"><i class="fa fa-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>
</section>
