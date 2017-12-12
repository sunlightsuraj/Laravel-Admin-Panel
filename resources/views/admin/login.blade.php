<?php
/**
 * User: suraj
 * Date: 3/15/17
 * Time: 7:32 PM
 */
?>

@extends('admin_master')

@section('wrapper')
	<div class="login-box">
		<div class="login-logo">
			<b>Admin</b>
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">Sign in to start your session</p>
			@if(isset($errors) && count($errors))
				<div class="alert alert-danger alert-dismissible">
					<button class="close" data-dismiss="alert">&times;</button>
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if(session('message'))
				<div class="alert alert-danger alert-dismissible">
					<button class="close" data-dismiss="alert">&times;</button>
					{{ session('message') }}
				</div>
			@endif
			<form action="{{ route('admin_login') }}" method="post">
				{{ csrf_field() }}
				<div class="form-group has-feedback">
					<input type="text" name="login" class="form-control" placeholder="Username or email">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="password" class="form-control" placeholder="Password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-8">
						{{--<div class="checkbox icheck">
							<label>
								<input type="checkbox"> Remember Me
							</label>
						</div>--}}
					</div>
					<!-- /.col -->
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
					</div>
					<!-- /.col -->
				</div>
			</form>
		</div>
		<!-- /.login-box-body -->
	</div>
@endsection