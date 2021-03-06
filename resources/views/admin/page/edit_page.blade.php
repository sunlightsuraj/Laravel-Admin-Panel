<?php
/**
 * User: suraj
 * Date: 4/9/17
 * Time: 1:31 PM
 */
?>

<section class="content-header">
	<h1>
		Edit Page
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<form action="{{ route('admin_page_edit', $page->id) }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group">
			<label for="title-input" class="text-info">Title</label>
			<input type="text" class="form-control" id="title-input" name="title" placeholder="Title" title="Page Title" value="{{ $page->title }}" required>
		</div>
		<div class="form-group">
			<label for="image-input" class="text-info">Featured Image</label>
			<input type="file" class="form-control" id="image-input" name="image" title="Featured Image">
			@if($page->image != '' && \File::exists(public_path('uploads/page/' . $page->image)))
				<br>
				<img src="{{ url('uploads/page/' . $page->image) }}" alt="{{ $page->image }}" class="img-responsive" style="width: 200px;">
			@endif
		</div>
		<div class="form-group">
			<label for="content" class="text-info">Content</label>
			<textarea name="content" id="content" data-role="wysiwyg" cols="30" rows="10" class="form-control">{{ $page->content }}</textarea>
		</div>
		<div class="form-group">
			<button class="btn btn-success pull-right" type="submit">Submit</button>
			<div class="clearfix"></div>
		</div>
	</form>
</section>


@push('scripts')
{{--<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>--}}
<script type="text/javascript" src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var editor = CKEDITOR.replace('content', {
			extraPlugins: 'uploadimage',
			uploadUrl: '{{ route('ckeditor_upload_image') }}'
		});
		editor.on( 'fileUploadRequest', function( evt ) {
			var xhr = evt.data.fileLoader.xhr;

			xhr.setRequestHeader( 'Cache-Control', 'no-cache' );
			xhr.setRequestHeader( 'X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content') );
			xhr.withCredentials = true;
		} );
	});
</script>
@endpush
