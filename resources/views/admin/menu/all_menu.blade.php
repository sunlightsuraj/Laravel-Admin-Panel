<?php
/**
 * User: suraj
 * Date: 4/9/17
 * Time: 3:44 PM
 */
?>


<section class="content-header">
	<a href="#" data-toggle="modal" data-target="#add-menu-modal" class="btn btn-primary btn-sm pull-right">Add Menu</a>
	<h1>
		Menu
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
		@if($menus)
			<div class="row">
				@php
					$i = 1;
				@endphp
				@foreach($menus as $menu)
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="pull-right">
									<a href="#"
									   data-mid="{{ $menu->id }}"
									   data-m="{{ $menu->menu_title }}"
									   data-ml="{{ $menu->menu_link }}"
									   data-lt="{{ $menu->link_type }}"
									   data-p="{{ $menu->page_id }}"
									   data-e="{{ $menu->entity }}"
									   data-pm="{{ $menu->parent_id }}"
									   data-po="{{ $menu->position }}" class="menu-edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i> Edit</a>
									<a href="{{ route('admin_menu_delete', $menu->id) }}" onclick="return window.confirm('Are you sure? You want to delete this menu.');"><i class="fa fa-trash"></i> Delete</a>
								</div>
								<h3 class="panel-title">{{ $menu->menu_title }}</h3>
							</div>
							<div class="panel-body">
								@if($menu->menu_link)
									<p class="text-info small">Link: <a href="{{ url($menu->menu_link) }}" target="_blank">{{ url($menu->menu_link) }}</a></p>
								@endif
								@if($menu->entity)
									<p class="bg-info" style="padding: 5px;">Entity: {{ $menu->entity }}</p>
								@endif
								@if($menu->page)
										<p class="bg-info" style="padding: 5px;">Page: <a href="{{ route('page', $menu->page->slug) }}" target="_blank">{{ $menu->page->title }}</a></p>
								@endif
								@if($menu->childMenus)
									<ul>
										@foreach($menu->childMenus as $childMenu)
											<li>
												<div class="pull-right">
													<a href="#"
													   data-mid="{{ $childMenu->id }}"
													   data-m="{{ $childMenu->menu_title }}"
													   data-ml="{{ $childMenu->menu_link }}"
													   data-lt="{{ $childMenu->link_type }}"
													   data-p="{{ $childMenu->page_id }}"
													   data-e="{{ $childMenu->entity }}"
													   data-pm="{{ $childMenu->parent_id }}"
													   data-po="{{ $childMenu->position }}" class="menu-edit" style="margin-right: 5px;"><i class="fa fa-pencil"></i> Edit</a>
													<a href="{{ route('admin_menu_delete', $childMenu->id) }}" onclick="return window.confirm('Are you sure? You want to delete this menu.');"><i class="fa fa-trash"></i> Delete</a>
												</div>
												{{ $childMenu->menu_title }}
											</li>
										@endforeach
									</ul>
								@endif
							</div>
						</div>
					</div>
					@if($i % 3 == 0)
						<div class="clearfix visible-md visible-lg"></div>
					@elseif($i % 2)
						<div class="clearfix visible-sm"></div>
					@endif
					@php
						$i++;
					@endphp
				@endforeach
			</div>
		@endif
	{{--<table class="table table-hover table-responsive">
		<thead>
		<tr>
			<th>S.N</th>
			<th>Title</th>
			<th>Parent</th>
			<th>Link</th>
			<th>Linked Page</th>
			<th>Entity</th>
			<th>Position</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		@if($menus)
			@php
			$i = 0;
			@endphp
			@foreach($menus as $menu)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $menu->menu_title }}</td>
					<td>{{ $menu->parent ? $menu->parent->menu_title : '' }}</td>
					<td>
						@if($menu->menu_link)
							@php
							$menu_link = preg_match('/^http/', $menu->menu_link) ? $menu->menu_link : url($menu->menu_link);
							@endphp
							<a href="{{ $menu_link }}"
							   target="{{ $menu->link_type == 'internal' ? '_self' : '_blank' }}">{{ $menu_link }}
							</a>
						@endif
					</td>
					<td>{{ $menu->page ? $menu->page->title : '' }}</td>
					<td>{{ $menu->entity }}</td>
					<td>{{ $menu->position }}</td>
					<td>
						<div class="dropdown">
							<a href="#" class="btn btn-primary btn-sm" data-toggle="dropdown">Action <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu">
								<li>
									<a href="#"
								    data-mid="{{ $menu->id }}"
								       data-m="{{ $menu->menu_title }}"
									data-ml="{{ $menu->menu_link }}"
									data-lt="{{ $menu->link_type }}"
									data-p="{{ $menu->page_id }}"
									data-e="{{ $menu->entity }}"
									data-pm="{{ $menu->parent_id }}"
									data-po="{{ $menu->position }}" class="menu-edit"><i class="fa fa-pencil"></i> Edit</a>
								</li>
								<li>
									<a href="{{ route('admin_menu_delete', $menu->id) }}" onclick="return window.confirm('Are you sure? You want to delete this menu.');"><i class="fa fa-trash"></i> Delete</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>--}}
</section>
<div class="modal" id="add-menu-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add Menu</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_menu_add') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="menu-title" class="text-info">Title</label>
						<input type="text" class="form-control" id="menu-title" name="title" placeholder="Title" title="Menu Title">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="menu-link" class="text-info">Menu Link</label>
								<input type="text" class="form-control" id="menu-link" name="menu_link"
								       placeholder="menu_link">
							</div>
							<div class="col-md-6">
								<label for="link-select" class="text-info">Or Select our static links</label>
								<select id="link-select" class="form-control" title="Select link">
									<option value="">Select link</option>
									{{-- add your static routes here --}}
									<option value="{{ route('home_contact_page') }}">{{ route('home_contact_page') }}</option>
								</select>
							</div>
						</div>
						<input type="radio" id="internal-link" name="link_type" title="Internal Link" value="internal" checked> <label
								for="internal-link"
								class="text-info">Internal</label>
						<input type="radio" id="external-link" name="link_type" title="External Link" value="external"> <label
								for="external-link"
								class="text-info">External Link</label>
					</div>
					<div class="form-group">
						<label for="page" class="text-info">Select page to link</label>
						<select name="page" id="page" class="form-control" title="Link with page">
							<option value="">Select page to link</option>
							@if($pages)
								@foreach($pages as $page)
									<option value="{{ $page->id }}">{{ $page->title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group">
						<label for="entity-input" class="text-info">Select entity for menu</label>
						<select name="entity" id="entity-input" class="form-control" title="Select entity">
							<option value="">Select entity for menu</option>
							<option value="product">Products</option>
							<option value="service">Services</option>
							<option value="download">Downloads</option>
						</select>
					</div>
					<div class="form-group">
						<label for="parent-menu" class="text-info">Select parent menu</label>
						<select name="parent" id="parent-menu" class="form-control" title="Parent Menu">
							<option value="">Select parent menu</option>
							@if($menus)
								@foreach($menus as $menu)
									<option value="{{ $menu->id }}">{{ $menu->menu_title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group">
						<label for="position-input" class="text-info">Position</label>
						<input type="number" class="form-control" id="position-input" name="position"
						       placeholder="Position" value="0">
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
<div class="modal" id="edit-menu-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Edit Menu</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_menu_edit') }}" method="post" id="edit-menu-form">
					{{ csrf_field() }}
					<input type="hidden" id="mid" name="mid" value="0">
					<div class="form-group">
						<label for="menu-title-edit" class="text-info">Title</label>
						<input type="text" class="form-control" id="menu-title-edit" name="title" placeholder="Title" title="Menu Title">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="menu-link-edit" class="text-info">Menu Link</label>
								<input type="text" class="form-control" id="menu-link-edit" name="menu_link" placeholder="menu_link">
							</div>
							<div class="col-md-6">
								<label for="link-select-edit" class="text-info">Or Select our static links</label>
								<select id="link-select-edit" class="form-control" title="Select link">
									<option value="">Select link</option>
									{{-- place your static routes here --}}
									<option value="{{ route('home_contact_page') }}">{{ route('home_contact_page') }}</option>
								</select>
							</div>
						</div>
						<input type="radio" id="internal-link-edit" name="link_type" title="Internal Link" value="internal" checked> <label
								for="internal-link-edit"
								class="text-info">Internal</label>
						<input type="radio" id="external-link-edit" name="link_type" title="External Link" value="external"> <label
								for="external-link-edit"
								class="text-info">External Link</label>
					</div>
					<div class="form-group">
						<label for="page-edit" class="text-info">Select page to link</label>
						<select name="page" id="page-edit" class="form-control" title="Link with page">
							<option value="">Select page to link</option>
							@if($pages)
								@foreach($pages as $page)
									<option value="{{ $page->id }}">{{ $page->title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group">
						<label for="entity-input-edit" class="text-info">Select entity for menu</label>
						<select name="entity" id="entity-input-edit" class="form-control" title="Select entity">
							<option value="">Select entity for menu</option>
							<option value="product">Products</option>
							<option value="service">Services</option>
							<option value="download">Downloads</option>
						</select>
					</div>
					<div class="form-group">
						<label for="parent-menu-edit" class="text-info">Select parent menu</label>
						<select name="parent" id="parent-menu-edit" class="form-control" title="Parent Menu">
							<option value="">Select parent menu</option>
							@if($menus)
								@foreach($menus as $menu)
									<option value="{{ $menu->id }}">{{ $menu->menu_title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group">
						<label for="position-input-edit" class="text-info">Position</label>
						<input type="number" class="form-control" id="position-input-edit" name="position"
						       placeholder="Position" value="0">
					</div>
					<p class="text-warning error small"></p>
					<div class="form-group">
						<button class="btn btn-success pull-right" type="submit">Edit</button>
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
		$('.menu-edit').click(function (event) {
			event.preventDefault();
			var t = $(this);
			var mid = t.data('mid');
			var m = t.data('m');
			var ml = t.data('ml');
			var lt = t.data('lt');
			var p = t.data('p');
			var e = t.data('e');
			var pm = t.data('pm');
			var po = t.data("po");
			$("#mid").val(mid);
			$("#menu-title-edit").val(m);
			$("#menu-link-edit").val(ml);
			if(lt == 'internal')
				$("#internal-link-edit").prop('checked', true);
			else
				$("#external-link-edit").prop('checked', true);
			$("#page-edit").val(p);
			$("#entity-input-edit").val(e);
			$("#parent-menu-edit").val(pm);
			$("#position-input-edit").val(po);

			$("#edit-menu-modal").modal('show');
		});
		
		$("#edit-menu-form").submit(function (event) {
			event.preventDefault();
			var t = $(this);
			var url = t.attr('action');
			var ok_btn = t.find('button[type="submit"]');
			var error_p = t.find('.error');
			ok_btn.html('<i class="fa fa-spinner fa-pulse fa-spin"></i> Edit');
			$.post(url, t.serialize(), function (response) {
				if(response.status == 'ok') {
					window.location.reload();
				} else {
					error_p.html(response.error);
				}
			}, 'json')
					.fail(function () {
						error_p.html('Request failed.');
					});
		});
		
		$("#link-select").change(function () {
			var v = $(this).val();
			$("#menu-link").val(v);
		});
		$("#link-select-edit").change(function () {
			var v = $(this).val();
			$("#menu-link-edit").val(v);
		});
	});
</script>
@endpush