<?php
/**
 * User: suraj
 * Date: 4/10/17
 * Time: 4:07 PM
 */
?>

<section class="content-header">
	<h1>
		Edit News
	</h1>
</section>

<section class="content">
	@if(session('message'))
		<div class="alert alert-info alert-dismissible">
			<button class="close" data-dismiss="alert">&times;</button>
			{!! session('message') !!}
		</div>
	@endif
	<form action="{{ route('admin_news_edit', $news->id) }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group">
			<label for="title-input" class="text-info">Title</label>
			<input type="text" class="form-control" id="title-input" name="title"
			       placeholder="News Title" value="{{ $news->title }}">
		</div>
		<div class="form-group">
			<label for="thumb-image-input" class="text-info">Thumbnail Image</label>
			<input type="file" class="form-control" id="thumb-image-input" name="thumb_image" title="Thumbnail Image">
			@if($news->thumbnail_image != '')
				<img src="{{ url('uploads/news/' . $news->thumbnail_image) }}" alt="{{ $news->service_title }}" style="width: 200px;">
			@endif
		</div>
		<div class="form-group">
			<label for="image-input" class="text-info">Page Featured Image</label>
			<input type="file" class="form-control" id="image-input" name="image" title="Featured Image">
			@if($page && $page->image != '')
				<img src="{{ url('uploads/page/' . $page->image) }}" alt="{{ $page->title }}" style="width: 200px;">
			@endif
		</div>
		<div class="form-group">
			<label for="description-input" class="text-info">Page Content</label>
			<textarea name="content" id="page-content-input" cols="30" rows="10" class="form-control"
			          placeholder="Description">{{ $page ? $page->content : '' }}</textarea>
		</div>
		<div class="form-group">
			<button class="btn btn-success pull-right" type="submit">Edit</button>
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
		} );

		$("#link-select").change(function () {
			var v = $(this).val();
			$("#page-link-input").val(v);
		});
	});
</script>
@endpush