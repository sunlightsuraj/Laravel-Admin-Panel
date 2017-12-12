<?php
/**
 * User: suraj
 * Date: 4/9/17
 * Time: 12:03 PM
 */
?>


<form action="{{ route('admin_slider_edit', [$slider->id]) }}" method="post" enctype="multipart/form-data" id="edit-slider-form">
	{{ csrf_field() }}
	<div class="form-group">
		<label for="slider-image-input" class="text-info">Slider Image</label>
		<input type="file" class="form-control" id="slider-image-input" name="slider_image"
		       title="Slider Image">
	</div>
	<div class="form-group">
		<label for="slider-title-input" class="text-info">Title</label>
		<input type="text" class="form-control" id="slider-title-input" name="title"
		       placeholder="Title" value="{{ $slider->slider_title }}">
	</div>
	<div class="form-group">
		<label for="slider-caption-input" class="text-info">Caption</label>
		<textarea name="caption" id="slider-caption-input" cols="10" rows="5" class="form-control"
		          placeholder="Caption">{{ $slider->slider_caption }}</textarea>
	</div>
	<div class="form-group">
		<label for="position-input" class="text-info">Position</label>
		<input type="number" class="form-control" id="position-input" name="position"
		       placeholder="Position" min="0" value="{{ $slider->position }}">
	</div>
	<p class="text-warning error small"></p>
	<div class="form-group">
		<button class="btn btn-success pull-right" type="submit">Update</button>
		<div class="clearfix"></div>
	</div>
</form>
