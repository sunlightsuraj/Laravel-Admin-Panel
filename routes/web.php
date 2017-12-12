<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::group(['namespace' => 'Home'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('contact', 'HomeController@contact')->name('home_contact_page');
    Route::post('contact', 'HomeController@contactPost')->name('home_contact_page');
});

Route::get('/logout', function (\Illuminate\Http\Request $request) {
	$request->session()->flush();
	return redirect()->route('admin_login');
})->name('logout');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
	Route::get('login', 'AdminController@loginView')->name('admin_login');

	Route::post('login', 'AdminController@login')->name('admin_login');

	Route::group(['middleware' => 'admin_check'], function () {
		Route::get('/', 'AdminController@dashboard')->name('admin_dashboard');

		Route::get('slider', 'SliderController@slider')->name("admin_slider");
		Route::post('slider/add', 'SliderController@addSlider')->name("admin_slider_add");
		Route::get('slider/{slider_id}/edit', 'SliderController@editSliderForm')->name("admin_slider_edit");
		Route::post('slider/{slider_id}/edit', 'SliderController@editSlider')->name('admin_slider_edit');
		Route::get('slider/{slider_id}/delete', 'SliderController@deleteSlider')->name('admin_slider_delete');

		Route::get('category', 'CategoryController@categories')->name('admin_category');
		Route::post('category/add', 'CategoryController@addCategory')->name('admin_category_add');
		Route::post('category/edit', 'CategoryController@editCategory')->name('admin_category_edit');
		Route::get('category/{category_id}/delete', 'CategoryController@deleteCategory')->name('admin_category_delete');

		Route::get('product', 'ProductController@products')->name('admin_product');
		Route::post('product/add', 'ProductController@addProduct')->name('admin_product_add');
		Route::post('product/edit', 'ProductController@editProduct')->name('admin_product_edit');
		Route::get('product/{product_id}/delete', 'ProductController@deleteProduct')->name('admin_product_delete');
		Route::get('product/{product_id}/image', 'ProductController@productImages')->name('admin_product_images');
		Route::post('product/{product_id}/image/upload', 'ProductController@uploadProductImages')->name('admin_product_images_upload');
		Route::get('product/image/{image_id}/delete', 'ProductController@deleteProductImage')->name('admin_product_image_delete');

		Route::get('service', 'ServiceController@services')->name('admin_service');
		Route::get('service/add', 'ServiceController@addServiceView')->name('admin_service_add');
		Route::post('service/add', 'ServiceController@addService')->name('admin_service_add');
		Route::get('service/{service_id}/edit', 'ServiceController@editServiceView')->name('admin_service_edit');
		Route::post('service/{service_id}/edit', 'ServiceController@editService')->name('admin_service_edit');
		Route::get('service/{service_id}/delete', 'ServiceController@deleteService')->name('admin_service_delete');
		Route::get('service/{service_id}/make-featured', 'ServiceController@makeFeatured')->name('admin_service_make_featured');

		Route::get('menu', 'MenuController@menus')->name('admin_menu');
		Route::post('menu/add', 'MenuController@addMenu')->name('admin_menu_add');
		Route::post('menu/edit', 'MenuController@editMenu')->name('admin_menu_edit');
		Route::get('menu/{menu_id}/delete', 'MenuController@deleteMenu')->name('admin_menu_delete');

		Route::get('page', 'PageController@pages')->name('admin_pages');
		Route::get('page/add', 'PageController@addPage')->name('admin_page_add');
		Route::post('page/add', 'PageController@addPagePost')->name('admin_page_add');
		Route::get('page/{page_id}/edit','PageController@editPage')->name('admin_page_edit');
		Route::post('page/{page_id}/edit', 'PageController@editPagePost')->name('admin_page_edit');
		Route::get('page/{page_id}/delete', 'PageController@deletePage')->name('admin_page_delete');

		Route::get('testimonial', 'TestimonialController@testimonials')->name('admin_testimonials');
		Route::post('testimonial/add', 'TestimonialController@addTestimonial')->name('admin_add_testimonial');
		Route::post('testimonial/edit', 'TestimonialController@editTestimonial')->name('admin_edit_testimonial');
		Route::get('testimonial/{testimonial_id}/delete', 'TestimonialController@deleteTestimonial')->name('admin_delete_testimonial');

		Route::get('download', 'DownloadController@downloads')->name('admin_download');
		Route::post('download/add', 'DownloadController@addDownload')->name('admin_download_add');
		Route::post('download/edit', 'DownloadController@editDownload')->name('admin_download_edit');
		Route::get('download/{download}/delete', 'DownloadController@deleteDownload')->name('admin_download_delete');

		Route::get('news', 'NewsController@news')->name('admin_news');
		Route::get('news/add', 'NewsController@addNews')->name('admin_news_add');
		Route::post('news/add', 'NewsController@addNewsPost')->name('admin_news_add');
		Route::get('news/{news_id}/edit', 'NewsController@editNewsView')->name('admin_news_edit');
		Route::post('news/{news_id}/edit', 'NewsController@editNews')->name('admin_news_edit');
		Route::get('news/{news_id}/delete', 'NewsController@deleteNews')->name('admin_news_delete');

		Route::get('contact-message', 'ContactMessageController@contactMessages')->name("admin_contact_messages");
		Route::get('contact-message/{message_id}/delete', 'ContactMessageController@deleteMessage')->name('admin_contact_message_delete');

		Route::get('user/profile', 'UserController@profile')->name('admin_user_profile');
		Route::post('user/profile/basic', 'UserController@updateBasic')->name('admin_user_profile_update_basic');
		Route::post('user/profile/password', 'UserController@updatePassword')->name('admin_user_password_update');
		Route::post('user/profile/image', 'UserController@updateImage')->name('admin_user_profile_image_update');

		Route::group(['middleware' => 'super_admin_check'], function () {
            Route::get('user', 'UserController@listAllUser')->name('admin_users');
            Route::post('user/add', 'UserController@userAdd')->name('admin_user_add');
            Route::post('user/edit', 'UserController@userEdit')->name("admin_user_edit");
            Route::get('user/{user_id}/delete', 'UserController@deleteUser')->name('admin_user_delete');
            Route::post('user/password', 'UserController@changePassword')->name('admin_user_change_password');
        });

		Route::post('ckeditor/upload-image', 'CkEditorController@uploadImage')->name('ckeditor_upload_image');
	});
});


Route::get('{slug}', function ($slug) {
	return $slug;
})->name('page');