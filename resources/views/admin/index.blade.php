<?php
/**
 * User: suraj
 * Date: 4/7/17
 * Time: 1:14 PM
 */
?>

@extends('admin_master')

@section('wrapper')
	<div class="wrapper">
	@include('admin.common.header')
	@include('admin.common.sidebar')

	<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			@if(isset($admin_page) && !empty($admin_page))
				@include('admin.' . $admin_page)
			@else
				@include('admin.dashboard.dashboard')
			@endif
		</div>
		<!-- /.content-wrapper -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2017 <a href="{{ url('/') }}"> Company Name</a>.</strong> All rights reserved.
		</footer>
	</div>
@endsection
