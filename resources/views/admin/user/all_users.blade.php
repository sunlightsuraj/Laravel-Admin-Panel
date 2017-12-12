<?php
/**
 * User: suraj
 * Date: 9/17/17
 * Time: 9:27 AM
 */
?>

<section class="content-header">
    <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#add-user-modal">Add User</a>
    <h1>
        Users
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

    @if($users)
        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th>S.N</th>
                <th>Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Image</th>
                <th>Super User</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php
            $i = 0;
            @endphp
            @foreach($users as $user)
                <tr>
                    <td>{{ ++$i  }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ $user->address }}</td>
                    <td>@if($user->profile_image) <img src="{{ url('uploads/user/' . $user->profile_image) }}"
                                                       alt="{{ $user->name }}" style="width: 150px; height: 150px;"> @endif</td>
                    <td>{{ $user->super_user ? 'yes' : 'no' }}</td>
                    <td>{{ $user->status ? 'active' : 'deactivated' }}</td>
                    <td>
                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm">Action <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" class="user-edit"
                                    data-uid="{{ $user->id }}"
                                    data-un="{{ $user->name }}"
                                       data-ue="{{ $user->email }}"
                                       data-uu="{{ $user->username }}"
                                       data-um="{{ $user->mobile }}"
                                       data-ua="{{ $user->address }}"
                                       data-usu="{{ $user->super_user }}"
                                       data-us="{{ $user->status }}"
                                       data-ui="{{ url('uploads/user/' . $user->profile_image) }}"
                                    ><i class="fa fa-pencil"></i> Edit</a> </li>
                                <li><a href="" data-uid="{{ $user->id }}" class="change-password"><i class="fa fa-key"></i> Change Password</a></li>
                                <li><a href="{{ route("admin_user_delete", [$user->id]) }}" onclick="return window.confirm('Are you sure you want to delete this user?');"><i class="fa fa-trash"></i> Delete</a> </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</section>

<div class="modal square" id="add-user-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <button class="close" data-dismiss="modal">&times;</button>
                    Add User
                </h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin_user_add') }}" id="user-add-form">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name-input" class="text-info">Name *</label>
                                <input type="text" class="form-control" id="name-input" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email-input" class="text-info">Email *</label>
                                <input type="email" class="form-control" id="email-input" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="username-input" class="text-info">Username</label>
                                <input type="text" class="form-control" id="username-input" name="username"
                                       placeholder="Username">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="user-image-input" class="text-info">Image</label>
                            <div class="thumbnail">
                                <img src="{{ url('dist/img/avatar.png') }}" alt="User Image" id="user-image-img" class="img-responsive">
                            </div>
                            <input type="file" class="form-control" id="user-image-input" name="user_image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile-input" class="text-info">Mobile</label>
                        <input type="text" class="form-control" id="mobile-input" name="mobile" placeholder="Mobile">
                    </div>
                    <div class="form-group">
                        <label for="address-input" class="text-info">Address</label>
                        <input type="text" class="form-control" id="address-input" name="address" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label for="password-input" class="text-info">Password *</label>
                        <input type="password" class="form-control" id="password-input" name="password"
                               placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm-input" class="text-info">Confirm Password *</label>
                        <input type="password" class="form-control" id="password-confirm-input"
                               name="password_confirmation"
                               placeholder="Confirm Password" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="super-user" name="super_user" title="Super Admin">
                        <label for="super-user" class="text-info">Super Admin</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="status" name="status" title="Activate">
                        <label for="status" class="text-info">Activate</label>
                    </div>
                    <p class="text-warning error small"></p>
                    <div class="form-group">
                        <button class="btn btn-primary pull-right" type="submit">Add</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal square" id="edit-user-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <button class="close" data-dismiss="modal">&times;</button>
                    Edit User
                </h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin_user_edit') }}" id="user-edit-form">
                    <input type="hidden" id="uid" value="0" name="uid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name-edit-input" class="text-info">Name *</label>
                                <input type="text" class="form-control" id="name-edit-input" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email-edit-input" class="text-info">Email *</label>
                                <input type="email" class="form-control" id="email-edit-input" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="username-edit-input" class="text-info">Username</label>
                                <input type="text" class="form-control" id="username-edit-input" name="username"
                                       placeholder="Username">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="user-image-edit-input" class="text-info">Image</label>
                            <div class="thumbnail">
                                <img src="{{ url('dist/img/avatar.png') }}" alt="User Image" id="user-image-edit-img" class="img-responsive">
                            </div>
                            <input type="file" class="form-control" id="user-image-edit-input" name="user_image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile-edit-input" class="text-info">Mobile</label>
                        <input type="text" class="form-control" id="mobile-edit-input" name="mobile" placeholder="Mobile">
                    </div>
                    <div class="form-group">
                        <label for="address-edit-input" class="text-info">Address</label>
                        <input type="text" class="form-control" id="address-edit-input" name="address" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="super-user-edit" name="super_user" title="Super Admin">
                        <label for="super-user-edit" class="text-info">Super Admin</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="status-edit" name="status" title="Activate">
                        <label for="status-edit" class="text-info">Activate</label>
                    </div>
                    <p class="text-warning error small"></p>
                    <div class="form-group">
                        <button class="btn btn-primary pull-right" type="submit">Edit</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal square" id="change-password-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Change Password</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin_user_change_password') }}" method="post" id="change-password-form">
                    <input type="hidden" id="p-uid" name="uid" value="0">
                    <div class="form-group">
                        <label for="new-password-input" class="text-info">New Password</label>
                        <input type="password" class="firm-control" id="new-password-input" name="password"
                               minlength="5"
                               maxlength="20" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password-input" class="text-info">Confirm Password</label>
                        <input type="password" class="firm-control" id="confirm-password-input" name="password_confirmation"
                               minlength="5"
                               maxlength="20" placeholder="Confirm Password">
                    </div>
                    <p class="text-warning error small"></p>
                    <div class="form-group">
                        <button class="btn btn-primary pull-right" type="submit">Update</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $(function(){
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

        $('#user-image-edit-input').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#user-image-edit-img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            else
            {
                $('#user-image-edit-img').attr('src', '{{ url('dist/img/avatar.png') }}');
            }
        });

        $("#user-add-form").submit(function (event) {
            event.preventDefault();
            var t = $(this);
            var url = t.attr('action');
            var ok_btn = t.find('button[type="submit"]');
            var error_p = t.find('.error');
            ok_btn.html('<i class="fa fa-spinner fa-spin"></i> Add');
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
                    ok_btn.html('Add');
                    if(response.status == 'ok') {
                        window.location.reload();
                    } else {
                        error_p.html(response.error);
                    }
                },
                error: function () {
                    ok_btn.html('Add');
                    error_p.html('Request failed.');
                }
            });
        });

        $("#user-edit-form").submit(function (event) {
            event.preventDefault();
            var t = $(this);
            var url = t.attr('action');
            var ok_btn = t.find('button[type="submit"]');
            var error_p = t.find('.error');
            ok_btn.html('<i class="fa fa-spinner fa-spin"></i> Edit').attr('disbled', true);
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
                    ok_btn.html('Edit');
                    if(response.status == 'ok') {
                        window.location.reload();
                    } else {
                        error_p.html(response.error);
                    }
                },
                error: function () {
                    ok_btn.html('Edit');
                    error_p.html('Request failed.');
                }
            });
        });

        $(".user-edit").click(function (event) {
            event.preventDefault();
            var t = $(this);
            var uid = t.data('uid');
            var un = t.data('un');
            var ue = t.data('ue');
            var uu = t.data('uu');
            var um = t.data('um');
            var ua = t.data('ua');
            var ui = t.data('ui');
            var usu = t.data('usu');
            var us = t.data('us');

            $("#uid").val(uid);
            $("#name-edit-input").val(un);
            $("#email-edit-input").val(ue);
            $("#username-edit-input").val(uu);
            $("#mobile-edit-input").val(um);
            $("#address-edit-input").val(ua);
            $("#user-image-edit-img").attr('src', ui);
            $("#super-user-edit").prop('checked', ( !!usu));
            $("#status-edit").prop('checked', ( !!us));

            $("#edit-user-modal").modal('show');
        });

        $(".change-password").click(function (event) {
            event.preventDefault();
            var t = $(this);
            var uid = t.data('uid');
            $("#p-uid").val(uid);
            $("#change-password-modal").modal('show');
        });

        $("#change-password-form").submit(function (event) {
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
                    ok_btn.removeAttr('disabled');
                    error_p.html(response.error);
                }
            }, 'json')
                .fail(function () {
                    ok_btn.html('Update');
                    ok_btn.removeAttr('disabled');
                });
        });
    });
</script>
@endpush