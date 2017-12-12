<?php
/**
 * User: suraj
 * Date: 4/7/17
 * Time: 1:15 PM
 */
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<a href="{{ route("admin_user_profile") }}">
			<div class="user-panel">
				<div class="pull-left image">
					<img src="{{ session('profile_image') ? url('uploads/user/' . session('profile_image')) : url('dist/img/avatar.png') }}" class="img-circle" alt="{{ session('name') }}">
				</div>
				<div class="pull-left info">
					<p>{{ session('name') }}</p>
					<!-- Status -->
					{{--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>--}}
				</div>
			</div>
		</a>

		<!-- search form (Optional) -->
		{{--<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
			</div>
		</form>--}}
		<!-- /.search form -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			{{--<li class="header">HEADER</li>--}}
			<!-- Optionally, you can add icons to the links -->
				<li class="{{ !isset($nav) || $nav == 'dashboard' ? 'active' : '' }}"><a href="{{ route('admin_dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
				<li class="{{ isset($nav) && $nav == 'slider' ? 'active' : '' }}"><a href="{{ route('admin_slider') }}"><i class="fa fa-leaf"></i> <span>Slider</span></a></li>
			<li class="{{ isset($nav) && $nav == 'category' ? 'active' : '' }}"><a href="{{ route('admin_category') }}"><i class="fa fa-leaf"></i> <span>Category</span></a></li>
				<li class="{{ isset($nav) && $nav == 'product' ? 'active' : '' }}"><a
							href="{{ route('admin_product') }}"><i class="fa fa-leaf"></i> <span>Product</span></a></li>
			<li class="{{ isset($nav) && $nav == 'service' ? 'active' : '' }}"><a href="{{ route('admin_service') }}"><i class="fa fa-leaf"></i> <span>Service</span></a></li>
				<li class="{{ isset($nav) && $nav == 'menu' ? 'active' : '' }}"><a href="{{ route('admin_menu') }}"><i class="fa fa-leaf"></i> <span>Menu</span></a></li>
				<li class="{{ isset($nav) && $nav == 'page' ? 'active' : '' }}"><a href="{{ route('admin_pages') }}"><i class="fa fa-leaf"></i> <span>Page</span></a></li>
				<li class="{{ isset($nav) && $nav == 'testimonial' ? 'active' : '' }}"><a href="{{ route('admin_testimonials') }}"><i class="fa fa-leaf"></i> <span>Testimonials</span></a></li>
				<li class="{{ isset($nav) && $nav == 'download' ? 'active' : '' }}"><a href="{{ route('admin_download') }}"><i class="fa fa-leaf"></i> <span>Download</span></a></li>
				<li class="{{ isset($nav) && $nav == 'news' ? 'active' : '' }}">
					<a href="{{ route('admin_news') }}"><i class="fa fa-leaf"></i> <span>News</span></a>
				</li>
				<li class="{{ isset($nav) && $nav == 'contact' ? 'active' : '' }}"><a
							href="{{ route('admin_contact_messages') }}"><i class="fa fa-leaf"></i> <span>Contact Message</span></a></li>

				@if(session("super_user"))
					<li class="{{ isset($nav) && $nav == 'user' ? 'active' : '' }}">
						<a href="{{ route('admin_users') }}"><i class="fa fa-user"></i> <span>Users</span></a>
					</li>
				@endif
			{{--<li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
					<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="#">Link in level 2</a></li>
					<li><a href="#">Link in level 2</a></li>
				</ul>
			</li>--}}
		</ul>
		<!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>
