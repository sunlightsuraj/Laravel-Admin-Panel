<?php
/**
 * User: suraj
 * Date: 4/11/17
 * Time: 6:38 PM
 */
?>

<section class="content-header">
	<a href="#" data-toggle="modal" data-target="#add-product-modal" class="btn btn-primary btn-sm pull-right">Add Product</a>
	<h1>
		Products
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
	<table class="table table-hover table-responsive table-stripped">
		<thead>
		<tr>
			<th>S.N</th>
			<th>Name</th>
			<th>Category</th>
			<th>Price</th>
			<th>Description</th>
			<th>

			</th>
		</tr>
		</thead>
		<tbody>
		@if($products)
			@php
			$i = 0;
			@endphp
			@foreach($products as $product)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $product->product_title }}</td>
					<td>{{ $categories->where('id', $product->category_id)->first()->category_title }}</td>
					<td>{{ $product->product_price }}</td>
					<td>{{ $product->product_description }}</td>
					<td>
						<a href="{{ route('admin_product_images', $product->id) }}" class="btn btn-info btn-sm pull-left" style="margin-right: 5px;"><i class="fa fa-picture-o"></i></a>
						<div class="dropdown" style="display: table;">
							<a href="#" class="btn btn-primary btn-sm" data-toggle="dropdown">Action <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#" class="edit-product" data-pid="{{ $product->id }}" data-pc="{{ $product->category_id }}" data-pt="{{ $product->product_title }}" data-pp="{{ $product->product_price }}" data-pd="{{ $product->product_description }}" data-pf="{{ $product->featured }}"><i class="fa fa-pencil"></i> Edit</a></li>
								<li><a href="{{ route('admin_product_delete', [$product->id]) }}" onclick="return window.confirm('Are you sure? You want to delete this product.');"><i class="fa fa-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>
</section>
<div class="modal" id="add-product-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add Product</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_product_add') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="category-input" class="text-info">Category</label>
						<select name="category" id="category-input" class="form-control" title="Category" required>
							<option value="">Select Category</option>
							@if($categories)
								@foreach($categories as $category)
									<option value="{{ $category->id }}">{{ $category->category_title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group">
						<label for="name-input" class="text-info">Product Name</label>
						<input type="text" class="form-control" id="name-input" name="name" placeholder="Product name"
						       title="Product name" required>
					</div>
					<div class="form-group">
						<label for="price-input" class="text-info">Price</label>
						<input type="text" class="form-control" id="price-input" name="price" placeholder="Price"
						       title="Price">
					</div>
					<div class="form-group">
						<label for="description-input" class="text-info">Description</label>
						<textarea name="description" id="description-input" cols="10" rows="5" class="form-control"
						          placeholder="Description" title="Description"></textarea>
					</div>
					<div class="form-group">
						<input type="checkbox" id="featured-input" name="featured" title="Featured Product">
						<label for="featured-input" class="text-info">Featured Product</label>
					</div>
					<div class="form-group">
						<button class="btn btn-primary pull-right" type="submit">Add Product</button>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="edit-product-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Edit Product</h3>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin_product_edit') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" id="pid" name="pid" value="0">
					<div class="form-group">
						<label for="category-edit-input" class="text-info">Category</label>
						<select name="category" id="category-edit-input" class="form-control" title="Category" required>
							<option value="">Select Category</option>
							@if($categories)
								@foreach($categories as $category)
									<option value="{{ $category->id }}">{{ $category->category_title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group">
						<label for="name-edit-input" class="text-info">Product Name</label>
						<input type="text" class="form-control" id="name-edit-input" name="name" placeholder="Product name"
						       title="Product name" required>
					</div>
					<div class="form-group">
						<label for="price-edit-input" class="text-info">Price</label>
						<input type="text" class="form-control" id="price-edit-input" name="price" placeholder="Price"
						       title="Price">
					</div>
					<div class="form-group">
						<label for="description-edit-input" class="text-info">Description</label>
						<textarea name="description" id="description-edit-input" cols="10" rows="5" class="form-control"
						          placeholder="Description" title="Description"></textarea>
					</div>
					<div class="form-group">
						<input type="checkbox" id="featured-edit-input" name="featured" title="Featured Product">
						<label for="featured-edit-input" class="text-info">Featured Product</label>
					</div>
					<div class="form-group">
						<button class="btn btn-primary pull-right" type="submit">Add Product</button>
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
		$(".edit-product").click(function (event) {
			event.preventDefault();
			var t = $(this);
			var pid = t.data('pid');
			var pc = t.data('pc');
			var pt = t.data('pt');
			var pp = t.data('pp');
			var pd = t.data('pd');
			var pf = parseInt(t.data('pf'));

			$("#pid").val(pid);
			$("#category-edit-input").val(pc);
			$("#name-edit-input").val(pt);
			$("#price-edit-input").val(pp);
			$('#description-edit-input').val(pd);
			if(pf == 1)
				$("#featured-edit-input").prop('checked', true);
			else
				$("#featured-edit-input").prop('checked', false);

			$("#edit-product-modal").modal('show');
		});
	});
</script>
@endpush