<?php
/**
 * User: suraj
 * Date: 10/2/17
 * Time: 3:07 AM
 */


namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $validation_message = [
        'name.required' => 'Please enter your full name.',
        'name.max:255' => 'Name should not be more than 255 characters long.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter your valid email address.',
        'email.max' => 'Email should not be more than 255 characters long.',
        'username.required' => 'Please enter username.',
        'username.max' => 'Username should not be more than 255 characters long.',
        'mobile.max' => 'Please enter valid mobile number',
        'address' => 'Please enter valid address.',
        'user_image.file' => 'User image must be a valid image file.',
        'user_image.mimes' => 'Please select valid image file.',
        'old_password.required' => 'Please enter password.',
        'old_password.min' => 'Password must be at least 5 characters long.',
        'old_password.max' => 'Password should not be more than 20 characters long.',
        'password.required' => 'Please enter password.',
        'password.min' => 'Password must be at least 5 characters long.',
        'password.max' => 'Password should not be more than 20 characters long.',
        'password.confirmed' => 'Invalid confirmation password.',
    ];

    protected function profile(Request $request) {
        $user_id = session('user_id');

        return view('admin.index', [
            'title' => 'Profile',
            'admin_page' => 'user.profile',
            'nav' => 'user'
        ]);
    }

    protected function updateBasic(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255|email',
            'username' => 'required|min:1|max:255',
            'mobile' => 'max:20',
            'address' => 'max:255'
        ], $this->validation_message);

        if($validator->fails())
            throw new CustomException(implode("<br>", $validator->errors()->all()));

        $name = $request->input('name');
        $email = $request->input('email');
        $username = $request->input('username');
        $mobile = $request->input("mobile");
        $address = $request->input('address');

        $user_id = session("user_id");

        $userCheck = User::where('id', '<>', $user_id)->where('email', $email)->first();
        if($userCheck)
            throw new CustomException("Email has been already taken.");

        $userCheck = User::where("id", '<>', $user_id)->where('username', $username)->first();
        if($userCheck)
            throw new CustomException('Username has been already taken.');

        $user = User::find($user_id);
        if(!$user)
            throw new CustomException("Invalid user.");

        $user->name = $name;
        $user->email = $email;
        $user->mobile = $mobile;
        $user->address = $address;
        $user->save();

        session()->put('name', $name);
        session()->put('email', $email);
        session()->put('username', $username);
        session()->put('mobile', $mobile);
        session()->put('address', $address);

        $request->session()->flash('message', 'Basic profile updated successfully.');

        if($request->ajax())
            return response()->json(['status' => 'ok']);
        else
            return redirect()->back();
    }

    protected function updatePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:5|max:20',
            'password' => 'required|min:5|max:20|confirmed'
        ], $this->validation_message);

        if($validator->fails())
            throw new CustomException(implode("<br>", $validator->errors()->all()));

        $old_password = $request->input('old_password');
        $password = $request->input('password');
        $password = bcrypt($password);

        $user_id = session('user_id');

        $user = User::find($user_id);
        if(!$user)
            throw new CustomException("Invalid user.");

        if(!Hash::check($old_password, $user->password))
            throw new CustomException("Old password did not match.");

        $user->password = $password;
        $user->save();

        $request->session()->flash('message', 'Password changed successfully.');

        if($request->ajax())
            return response()->json(['status' => 'ok']);
        else
            return redirect()->back();
    }

    protected function updateImage(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_image' => 'nullable|file|mimes:png,jpg,jpeg,JPG,gif,bmp'
        ], $this->validation_message);

        if($validator->fails())
            throw new CustomException(implode("<br>", $validator->errors()->all()));

        $user_id = session('user_id');
        $name = session('name');

        $user = User::find($user_id);
        if(!$user)
            throw new CustomException("Invalid user image.");

        if($request->hasFile('user_image') && $request->file('user_image')->isValid()) {
            $file = $request->file('user_image');
            $file_name = str_slug($name) . '-' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/user/', $file_name);

            if($user->profile_image != '' && \File::exists(public_path('uploads/user/' . $user->profile_image)))
                \File::delete(public_path('uploads/user/' . $user->profile_image));

            $user->profile_image = $file_name;
            $user->save();

            session()->put('profile_image', $file_name);
        } else
            throw new CustomException("Invalid image file.");

        $request->session()->flash('message', 'Profile image updated successfully.');
        if($request->ajax())
            return response()->json(['status' => 'ok']);
        else
            return redirect()->back();
    }

    protected function listAllUser() {
        $user_id = session('user_id');
        $users = User::where('id', '<>', $user_id)->get();

        return view('admin.index', [
            'title' => 'Users',
            'admin_page' => 'user.all_users',
            'nav' => 'user',
            'users' => $users
        ]);
    }

    protected function userAdd(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|min:1|max:255|unique:user',
            'username' => 'nullable|min:0|max:255|unique:user',
            'mobile' => 'nullable|min:0|max:15',
            'address' => 'nullable|min:0|max:255',
            'password' => 'required|min:5|max:20|confirmed',
            'user_image' => 'nullable|file|mimes:png,jpg,jpeg,JPG,gif,bmp',
        ], $this->validation_message);

        if($validator->fails())
            throw new CustomException(implode('<br>', $validator->errors()->all()));

        $name = $request->input('name');
        $email = $request->input("email");
        $username = $request->input('username');
        $mobile = $request->input('mobile');
        $address = $request->input('address');
        $password = $request->input('password');
        $password = bcrypt($password);

        $user_image = '';
        if($request->hasFile('user_image') && $request->file('user_image')->isValid()) {
            $file = $request->file('user_image');
            $file_name = str_slug($name) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/user/', $file_name);
            $user_image = $file_name;
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->username = $username;
        $user->mobile = $mobile;
        $user->address = $address;
        $user->password = $password;
        $user->profile_image = $user_image;
        $user->super_user = $request->has('super_user') ? 1 : 0;
        $user->status = $request->has('status') ? 1 : 0;
        $user->save();

        if($request->ajax()) {
            $request->session()->flash('message', 'New user created successfully.');
            return response()->json(['status' => 'ok']);
        } else
            return redirect()->back();
    }

    protected function userEdit(Request $request) {
        $validator = Validator::make($request->all(), [
            'uid' => 'required|integer|min:1',
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|min:1|max:255',
            'username' => 'nullable|min:0|max:255',
            'mobile' => 'nullable|min:0|max:15',
            'address' => 'nullable|min:0|max:255',
            'user_image' => 'nullable|file|mimes:png,jpg,jpeg,JPG,gif,bmp',
        ], $this->validation_message);

        if($validator->fails())
            throw new CustomException(implode('<br>', $validator->errors()->all()));

        $user_id = $request->input('uid');
        $name = $request->input('name');
        $email = $request->input("email");
        $username = $request->input('username');
        $mobile = $request->input('mobile');
        $address = $request->input('address');
        $password = $request->input('password');

        $userCheck = User::where('id', '<>', $user_id)->where('email', $email)->first();
        if($userCheck)
            throw new CustomException("Email has been already taken.");

        $userCheck = User::where("id", '<>', $user_id)->where('username', $username)->first();
        if($userCheck)
            throw new CustomException('Username has been already taken.');

        $user = User::find($user_id);
        if(!$user)
            throw new CustomException("Invalid User.");
        $user->name = $name;
        $user->email = $email;
        $user->username = $username;
        $user->mobile = $mobile;
        $user->address = $address;

        if($request->hasFile('user_image') && $request->file('user_image')->isValid()) {
            $file = $request->file('user_image');
            $file_name = str_slug($name) . '-' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/user/', $file_name);

            if($user->profile_image != '' && \File::exists(public_path('uploads/user/' . $user->profile_image)))
                \File::delete(public_path('uploads/user/' . $user->profile_image));

            $user->profile_image = $file_name;
        }

        $user->super_user = $request->has('super_user') ? 1 : 0;
        $user->status = $request->has('status') ? 1 : 0;
        $user->save();

        if($request->ajax()) {
            $request->session()->flash('message', 'User updated successfully.');
            return response()->json(['status' => 'ok']);
        } else
            return redirect()->back();
    }

    protected function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'uid' => 'required|integer|min:1',
            'password' => 'required|min:5|max:20|confirmed'
        ], $this->validation_message);

        if($validator->fails())
            throw new CustomException(implode("<br>", $validator->errors()->all()));

        $password = $request->input('password');
        $password = bcrypt($password);

        $user_id = $request->input('uid');

        $user = User::find($user_id);
        if(!$user)
            throw new CustomException("Invalid user.");

        $user->password = $password;
        $user->save();

        $request->session()->flash('message', 'Password changed successfully.');

        if($request->ajax())
            return response()->json(['status' => 'ok']);
        else
            return redirect()->back();
    }

    protected function deleteUser(Request $request, $user_id) {
        $user = User::find($user_id);
        if(!$user)
            throw new CustomException("Invalid User");

        $user->delete();

        $request->session()->flash('message', 'User deleted successfully.');
        return redirect()->back();
    }
}
