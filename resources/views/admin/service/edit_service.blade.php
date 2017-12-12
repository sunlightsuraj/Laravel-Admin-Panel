<?php
/**
 * User: suraj
 * Date: 4/10/17
 * Time: 4:07 PM
 */
?>

<section class="content-header">
	<h1>
		Edit Service
	</h1>
</section>

<section class="content">
	@if(session('message'))
		<div class="alert alert-info alert-dismissible">
			<button class="close" data-dismiss="alert">&times;</button>
			{!! session('message') !!}
		</div>
	@endif
	<form action="{{ route('admin_service_edit', $service->id) }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group">
			<label for="parent-input" class="text-info">Parent service</label>
			<select name="parent" id="parent-input" class="form-control"
			        title="Select parent service">
				<option value="">Select parent service</option>
				@if($services)
					@foreach($services as $s)
						<option value="{{ $s->id }}"{{ $service->parent_id == $s->id ? ' selected' : '' }}>{{ $s->service_title }}</option>
					@endforeach
				@endif
			</select>
		</div>
		<div class="form-group">
			<label for="service-title-input" class="text-info">Title</label>
			<input type="text" class="form-control" id="service-title-input" name="title"
			       placeholder="Service Title" value="{{ $service->service_title }}">
		</div>
		<div class="form-group">
			<label for="thumb-image-input" class="text-info">Thumbnail Image</label>
			<input type="file" class="form-control" id="thumb-image-input" name="thumb_image" title="Thumbnail Image">
			@if($service->thumbnail_image != '')
				<img src="{{ url('uploads/service/' . $service->thumbnail_image) }}" alt="{{ $service->service_title }}" style="width: 200px;">
			@endif
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label for="page-link-input" class="text-info">Page link</label>
					<input type="text" class="form-control" id="page-link-input" name="link" placeholder="Service page link" value="{{ $service->link }}">
				</div>
				<div class="col-md-6">
					<label for="link-select" class="text-info">Or Select our static links</label>
					<select id="link-select" class="form-control" title="Select link">
						<option value="">Select link</option>
						<option value="{{ url('example.com') }}">{{ url('example.com') }}</option>
						<option value="{{ url('another-example.com') }}">{{ url('another-example.com') }}</option>
					</select>
				</div>
			</div>
		</div>
		<label class="text-info">Or</label>
		<div class="form-group">
			<label for="image-input" class="text-info">Featured Image</label>
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
		{{--<div class="form-group">
			<label for="pages-list" class="text-info">Select content page</label>
			<select name="page" id="pages-list" class="form-control" title="Pages">
				<option value="">Select content page</option>
				@if($pages)
					@foreach($pages as $page)
						<option value="{{ $page->id }}">{{ $page->title }}</option>
					@endforeach
				@endif
			</select>
		</div>--}}
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