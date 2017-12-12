<?php
/**
 * User: suraj
 * Date: 4/10/17
 * Time: 10:47 AM
 */
?>

<section class="content-header">
	<a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#add-testimonial-modal">Add Testimonial</a>
	<h1>
		Testimonial
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

	@if($testimonials)
			<div class="row">
				@php
				$i = 1;
				@endphp
				@foreach($testimonials as $testimonial)
					<div class="col-sm-6 col-md-4">
						<div class="panel panel-default">
							<div class="modal-body text-center">
								<div class="pull-right dropdown">
									<a href="#" data-toggle="dropdown"><i class="fa fa-angle-down"></i></a>
									<ul class="dropdown-menu">
										<li><a href="#"
										       class="edit-testimonial"
										       data-tid="{{ $testimonial->id }}"
										       data-name="{{ $testimonial->name }}"
										       data-message="{{ $testimonial->message }}"><i class="fa fa-pencil"></i> Edit</a></li>
										<li><a href="{{ route("admin_delete_testimonial", [$testimonial->id]) }}" onclick="return window.confirm('Are you sure? You want to delete this testimonial.');"><i class="fa fa-trash"></i> Delete</a> </li>
									</ul>
								</div>
								@if($testimonial->image != '')
									<img src="{{ url('uploads/testimonial/'. $testimonial->image) }}"
									     alt="{{ $testimonial->name }}"
									     class="img-circle img-responsive" style="width: 200px;height: 200px;margin: auto;">
								@endif
								<h3>{{ $testimonial->name }}</h3>
								<p>{{ $testimonial->message }}</p>
							</div>
						</div>
					</div>
					@if($i % 3 == 0)
						<div class="clearfix visible-md visible-lg"></div>
					@elseif($i % 2 == 0)
						<div class="visible-sm"></div>
					@endif
					@php
					$i++;
					@endphp
				@endforeach
			</div>
	@endif
</section>
<div class="modal" id="add-testimonial-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">
					Add Testimonial
				</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_add_testimonial') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="image-input" class="text-info">Testimonial Image</label>
						<input type="file" class="form-control" id="image-input" name="image" title="Testimonial Image">
					</div>
					<div class="form-group">
						<label for="name-input" class="text-info">Testimonial By</label>
						<input type="text" class="form-control" id="name-input" name="name"
						       placeholder="Testimonial By">
					</div>
					<div class="form-group">
						<label for="message-input" class="text-info">Message</label>
						<textarea name="message" id="message-input" cols="30" rows="10" class="form-control"
						          placeholder="Message"></textarea>
					</div>
					<p class="text-warning error small"></p>
					<div class="form-group">
						<button class="btn btn-success pull-right" type="submit">Add</button>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="edit-testimonial-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">
					Edit Testimonial
				</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_edit_testimonial') }}" method="post" enctype="multipart/form-data" id="edit-testimonial-form">
					{{ csrf_field() }}
					<input type="hidden" id="tid" name="tid" value="0">
					<div class="form-group">
						<label for="image-edit-input" class="text-info">Testimonial Image</label>
						<input type="file" class="form-control" id="image-edit-input" name="image" title="Testimonial Image">
					</div>
					<div class="form-group">
						<label for="name-edit-input" class="text-info">Testimonial By</label>
						<input type="text" class="form-control" id="name-edit-input" name="name"
						       placeholder="Testimonial By">
					</div>
					<div class="form-group">
						<label for="message-edit-input" class="text-info">Message</label>
						<textarea name="message" id="message-edit-input" cols="30" rows="10" class="form-control"
						          placeholder="Message"></textarea>
					</div>
					<p class="text-warning error small"></p>
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
		$(".edit-testimonial").click(function (event) {
			event.preventDefault();
			var t = $(this);
			var tid = t.data('tid');
			var name = t.data('name');
			var message = t.data('message');

			$("#tid").val(tid);
			$("#name-edit-input").val(name);
			$("#message-edit-input").val(message);
			$("#edit-testimonial-modal").modal('show');
		});
	});
</script>
@endpush