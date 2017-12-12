<?php
/**
 * User: suraj
 * Date: 10/2/17
 * Time: 3:07 AM
 */
?>

@if(session('message'))
    <br>
    <div class="container">
        <div class="col-md-8">
            <div class="alert alert-info alert-dismissible">
                <button class="close" data-dismiss="alert">&times;</button>
                {!! session('message') !!}
            </div>
        </div>
    </div>
@endif

<section class="content-header">
    <h1>
        My Profile
    </h1>
</section>

<section class="content profile-section">
    <div class="row">
        <div class="col-md-9">
            <div>
                <form action="{{ route('admin_user_profile_update_basic') }}" id="basic-profile-update" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name-input" class="text-info">Name</label>
                        <input type="text" class="form-control" id="name-input" name="name" placeholder="Your full name" value="{{ session('name') }}" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="email-input" class="text-info">Email</label>
                        <input type="email" class="form-control" id="email-input" name="email" placeholder="Email"
                               value="{{ session('email') }}" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="username-input" class="text-info">Username</label>
                        <input type="text" class="form-control" id="username-input" name="username" placeholder="Username"
                               value="{{ session('username') }}" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile-input" class="text-info">Mobile</label>
                        <input type="text" class="form-control" id="mobile-input" name="mobile" placeholder="Mobile"
                               value="{{ session('mobile') }}" maxlength="20">
                    </div>
                    <div class="form-group">
                        <label for="address-input" class="text-info">Address</label>
                        <input type="text" class="form-control" id="address-input" name="address" placeholder="Address"
                               value="{{ session('address') }}" maxlength="255">
                    </div>
                    <p class="text-warning error small"></p>
                    <div class="form-group">
                        <button class="btn btn-primary pull-right" type="submit">Update</button>
                    </div>
                </form>
            </div>
            <br>
            <br>
            <div>
                <h4>Change Password</h4>
                <form action="{{ route('admin_user_password_update') }}" method="post" id="password-form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="old-password" class="text-info">Old Password</label>
                        <input type="password" class="form-control" id="old-password" name="old_password"
                               placeholder="Old Password" minlength="5" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="password-input" class="text-info">Password</label>
                        <input type="password" class="form-control" id="password-input" name="password"
                               placeholder="New Password" minlength="5" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="text-info">Confirm Password</label>
                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm Password" minlength="5" maxlength="20" required>
                    </div>
                    <p class="text-warning error small"></p>
                    <div class="form-group">
                        <button class="btn btn-primary pull-right" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="user-image-input" class="text-info">Image</label>
            <div class="thumbnail">
                <img src="{{ session('profile_image') ? url('uploads/user/' . session('profile_image')) : url('dist/img/avatar.png') }}" alt="User Image" id="user-image-img" class="img-responsive">
            </div>
            <form action="{{ route('admin_user_profile_image_update') }}" method="post" id="profile-image-form">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="file" class="form-control" id="user-image-input" name="user_image">
                </div>
                <p class="text-warning error small"></p>
                <div class="form-group">
                    <button class="btn btn-primary pull-right" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#basic-profile-update").submit(function (event) {
                event.preventDefault();
                var t = $(this);
                var ok_btn = t.find('button[type="submit"]');
                var error_p = t.find('.error');
                var url = t.attr('action');
                ok_btn.html('<i class="fa fa-spinner fa-pulse fa-spin"></i> Update');
                $.post(url, t.serialize(), function (response) {
                    ok_btn.html('Update');
                    if(response.status == 'ok') {
                        window.location.reload();
                    } else {
                        error_p.html(response.error);
                    }
                }, 'json')
                    .fail(function () {
                        ok_btn.html('Update');
                    });
            });

            $("#password-form").submit(function (event) {
                event.preventDefault();
                var t = $(this);
                var ok_btn = t.find('button[type="submit"]');
                var error_p = t.find('.error');
                var url = t.attr('action');
                ok_btn.html('<i class="fa fa-spinner fa-pulse fa-spin"></i> Update');
                $.post(url, t.serialize(), function (response) {
                    ok_btn.html('Update');
                    if(response.status == 'ok') {
                        window.location.reload();
                    } else {
                        error_p.html(response.error);
                    }
                }, 'json')
                    .fail(function () {
                        ok_btn.html('Update');
                    });
            });

            $('#user-image-input').change(function(){
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
                {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#user-image-img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else
                {
                    $('#user-image-img').attr('src', '{{ url('dist/img/avatar.png') }}');
                }
            });

            $("#profile-image-form").submit(function (event) {
                event.preventDefault();
                var t = $(this);
                var url = t.attr('action');
                var ok_btn = t.find('button[type="submit"]');
                var error_p = t.find('.error');
                ok_btn.html('<i class="fa fa-spinner fa-spin"></i> Update');
                error_p.html('');
                $.ajax({
                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        ok_btn.html('Update');
                        if(response.status == 'ok') {
                            window.location.reload();
                        } else {
                            error_p.html(response.error);
                        }
                    },
                    error: function () {
                        ok_btn.html('Update');
                        error_p.html('Request failed.');
                    }
                });
            });
        });
    </script>
@endpush