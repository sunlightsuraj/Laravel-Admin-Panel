<?php
/**
 * User: suraj
 * Date: 4/7/17
 * Time: 1:13 PM
 */
?>

<!-- Main Header -->
<header class="main-header">

	<!-- Logo -->
	<a href="{{ route('admin_dashboard') }}" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>{{ env('SITE_SHORT_NAME') }}</b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>{{ env('SITE_NAME') }}</b></span>
	</a>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li><a href="{{ url('/')  }}" target="_blank">Visit Site</a></li>
				<li><a href="{{ route('logout') }}">Logout</a></li>
			</ul>
		</div>
	</nav>
</header>
