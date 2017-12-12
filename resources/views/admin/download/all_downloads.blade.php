<?php
/**
 * User: suraj
 * Date: 4/10/17
 * Time: 2:48 PM
 */
?>

<section class="content-header">
	<a href="#" data-toggle="modal" data-target="#add-download-modal" class="btn btn-primary btn-sm pull-right">Add Download</a>
	<h1>
		Downloads
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
	<table class="table table-hover table-stripped table-responsive">
		<thead>
		<tr>
			<th>S.N</th>
			<th>Title</th>
			<th>File</th>
			<th>External Link</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		@if($downloads)
			@php
			$i = 0;
			@endphp
			@foreach($downloads as $download)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $download->download_title }}</td>
					<td>
						@if($download->download_file != "")
							<a href="{{ url('uploads/download/' . $download->download_file) }}" target="_blank">{{ $download->download_file }}</a>
						@endif
					</td>
					<td>
						@if($download->download_link != "")
							<a href="{{ url($download->download_link) }}" target="_blank">{{ url($download->download_link) }}</a>
						@endif
					</td>
					<td>
						<div class="dropdown">
							<a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm">Action <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#" class="edit-download" data-did="{{ $download->id }}" data-dt="{{ $download->download_title }}" data-dl="{{ $download->download_link }}"><i class="fa fa-pencil"></i> Edit</a></li>
								<li><a href="{{ route('admin_download_delete', [$download->id]) }}" onclick="return window.confirm('Are you sure? You want to delete this download.');"><i class="fa fa-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>
</section>
<div class="modal" id="add-download-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="close">&times;</button>
				<h3 class="modal-title">Add Download</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_download_add') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="title-input" class="text-info">Download Title</label>
						<input type="text" class="form-control" id="title-input" name="title" placeholder="Title">
					</div>
					<div class="form-group">
						<label for="file-input" class="text-info">Download File</label>
						<input type="file" class="form-control" id="file-input" name="file" title="File">
					</div>
					<label class="text-info">Or</label>
					<div class="form-group">
						<label for="link-input" class="text-info">External Download Link</label>
						<input type="text" class="form-control" id="link-input" name="link" placeholder="Download Link"
						       title="Download Link">
					</div>
					<p class="text-warning error"></p>
					<div class="form-group">
						<button class="btn btn-primary btn-sm pull-right" type="submit">Add</button>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="edit-download-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="close">&times;</button>
				<h3 class="modal-title">Edit Download</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_download_edit') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" id="did" name="did" value="0">
					<div class="form-group">
						<label for="title-edit-input" class="text-info">Download Title</label>
						<input type="text" class="form-control" id="title-edit-input" name="title" placeholder="Title">
					</div>
					<div class="form-group">
						<label for="file-edit-input" class="text-info">Download File</label>
						<input type="file" class="form-control" id="file-edit-input" name="file" title="File">
					</div>
					<label class="text-info">Or</label>
					<div class="form-group">
						<label for="link-edit-input" class="text-info">External Download Link</label>
						<input type="text" class="form-control" id="link-edit-input" name="link" placeholder="Download Link"
						       title="Download Link">
					</div>
					<p class="text-warning error"></p>
					<div class="form-group">
						<button class="btn btn-primary btn-sm pull-right" type="submit">Add</button>
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
		$(".edit-download").click(function (event) {
			event.preventDefault();
			var t = $(this);
			var did = t.data('did');
			var dt = t.data('dt');
			var dl = t.data('dl');
			$("#did").val(did);
			$("#title-edit-input").val(dt);
			$("#link-edit-input").val(dl);
			$("#edit-download-modal").modal('show');
		});
	});
</script>
@endpush