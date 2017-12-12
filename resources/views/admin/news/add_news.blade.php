<?php
/**
 * User: suraj
 * Date: 4/11/17
 * Time: 2:10 PM
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

		<form action="{{ route('admin_news_add') }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="title-input" class="text-info">Title</label>
				<input type="text" class="form-control" id="title-input" name="title" placeholder="Title">
			</div>
			<div class="form-group">
				<label for="thumbnail-image-input" class="text-info">Thumbnail Image</label>
				<input type="file" class="form-control" id="thumbnail-image-input" name="thumb_image"
				       title="Thumbnail Image">
			</div>
			<div class="form-group">
				<label for="image-input" class="text-info">Page Featured Image</label>
				<input type="file" class="form-control" id="image-input" name="image" title="Featured Image">
			</div>
			<div class="form-group">
				<label for="description-input" class="text-info">Page Content</label>
				<textarea name="content" id="page-content-input" cols="30" rows="20" class="form-control"
				          placeholder="Description"></textarea>
			</div>
			<div class="form-group">
				<button class="btn btn-success pull-right" type="submit">Add</button>
				<div class="clearfix"></div>
			</div>
		</form>
</section>

@push('scripts')
{{--<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>--}}
<script type="text/javascript" src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var editor = CKEDITOR.replace('page-content-input', {
			extraPlugins: 'uploadimage',
			uploadUrl: '{{ route('ckeditor_upload_image') }}'
		});
		editor.on( 'fileUploadRequest', function( evt ) {
			var xhr = evt.data.fileLoader.xhr;

			xhr.setRequestHeader( 'Cache-Control', 'no-cache' );
			xhr.setRequestHeader( 'X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content') );
			xhr.withCredentials = true;
		});

		$("#link-select").change(function () {
			var v = $(this).val();
			$("#page-link-input").val(v);
		});
	});
</script>
@endpush