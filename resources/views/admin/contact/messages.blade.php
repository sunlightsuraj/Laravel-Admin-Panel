<?php
/**
 * User: suraj
 * Date: 4/10/17
 * Time: 5:24 PM
 */
?>

<section class="content-header">
	<h1>
		Contact Messages
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
			<th>Name</th>
			<th>Email</th>
			<th>Address</th>
			<th>Phone</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@if($contactMessages)
			@php
			$i = 0;
			@endphp
			@foreach($contactMessages as $contactMessage)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $contactMessage->name }}</td>
					<td>{{ $contactMessage->email }}</td>
					<td>{{ $contactMessage->address }}</td>
					<td>{{ $contactMessage->phone }}</td>
					<td>
						<a href="#" data-n="{{ $contactMessage->name }}"
						   data-e="{{ $contactMessage->email }}"
						   data-ad="{{ $contactMessage->address }}"
						   data-phone="{{ $contactMessage->phone }}"
						   data-message="{{ $contactMessage->message }}" class="btn btn-primary btn-sm see-message"><i class="fa fa-search-plus"></i></a>
						<a href="{{ route('admin_contact_message_delete', $contactMessage->id) }}" onclick="return window.confirm('Are you sure? You want to delete this message.');" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>
</section>
<div class="modal" id="see-message-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button class="close" data-dismiss="modal">&times;</button>
				<p><strong>Name: <span id="name"></span></strong></p>
				<p><strong>Email: <span id="email"></span></strong></p>
				<p><strong>Address: <span id="address"></span></strong></p>
				<p><strong>Phone: <span id="phone"></span></strong></p>
				<p><strong>Message: <span id="message"></span></strong></p>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script type="text/javascript">
	$(document).ready(function () {
		$(".see-message").click(function (event) {
			event.preventDefault();
			var t = $(this);
			var n = t.data('n');
			var e = t.data('e');
			var ad = t.data('ad');
			var phone = t.data('phone');
			var message = t.data('message');

			$("#name").text(n);
			$("#email").text(e);
			$("#address").text(ad);
			$("#phone").text(phone);
			$("#message").text(message);

			$("#see-message-modal").modal('show');
		});
	});
</script>
@endpush