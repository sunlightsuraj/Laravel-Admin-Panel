<?php
/**
 * User: suraj
 * Date: 4/7/17
 * Time: 2:09 PM
 */

namespace App\Http\Controllers\Admin;


use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Slider;
use App\Category;
use App\BlogNews;
use App\ContactMessage;
use App\Download;
use App\Menu;
use App\Page;
use App\Product;
use App\Service;
use App\Testimonial;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {

	protected function loginView() {
		return view('admin.login');
	}

	protected function login(Request $request) {
		$validator = Validator::make($request->all(), [
			'login' => 'required|min:1|max:255',
			'password' => 'required|min:1|max:60',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$login = $request->input('login');
		$password = $request->input('password');

		$user = User::where(function ($query) use ($login) {
		    $query->where('email', $login)->orWhere('username', $login);
        })->where('status', 1)->first();

		if(!$user)
			throw new CustomException("Invalid username or email.");

		if(!Hash::check($password, $user->password))
			throw new CustomException("Invalid Password");

		$user_id = $user->id;
		$name = $user->name;
		$email = $user->email;
		$username = $user->username;
		$mobile = $user->mobile;
		$address = $user->address;
		$profile_image = $user->profile_image;
		$super_user = $user->super_user;
		$status = 1;

		session([
			'sess_admin' => true,
			'user_id' => $user_id,
			'name' => $name,
			'email' => $email,
			'username' => $username,
			'mobile' => $mobile,
			'address' => $address,
            'profile_image' => $profile_image,
            'super_user' => $super_user
		]);

		/*$_SESSION['sess_admin'] = true;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['email'] = $email;
		$_SESSION['username'] = $username;
		$_SESSION['mobile'] = $mobile;
		$_SESSION['address'] = $address;*/

		return redirect()->route('admin_dashboard');
	}

	protected function dashboard() {
		$sliders_count = Slider::count();
		$category_count = Category::count();
		$product_count = Product::count();
		$service_count = Service::count();
		$menu_count = Menu::count();
		$page_count = Page::count();
		$testimonial_count = Testimonial::count();
		$news_count = BlogNews::count();
		$download_count = Download::count();
		$message_count = ContactMessage::count();
		$users_count = User::count();

		return view('admin.index', [
			'sliders_count' => $sliders_count,
			'category_count' => $category_count,
			'product_count' => $product_count,
			'service_count' => $service_count,
			'menu_count' => $menu_count,
			'page_count' => $page_count,
			'testimonial_count' => $testimonial_count,
			'news_count' => $news_count,
			'download_count' => $download_count,
			'message_count' => $message_count,
            'users_count' => $users_count
		]);
	}
}