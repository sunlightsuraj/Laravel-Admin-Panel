<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Page;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    protected function services(Request $request) {
		$services = Service::with('parent')->get();
		$pages = Page::where('status', 1)->get();

		return view('admin.index', [
			'title' => 'Service',
			'nav' => 'service',
			'admin_page' => 'service.all_service',
			'services' => $services,
			'pages' => $pages,
		]);
	}

	protected function addServiceView(Request $request) {
		$services = Service::where('parent_id', 0)->get();
		/*$pages = Page::where('status', 1)->get();*/
		return view('admin.index', [
			'title' => "Add Service",
			'nav' => 'service',
			'admin_page' => 'service.add_service',
			'services' => $services,
			/*'pages' => $pages*/
		]);
	}

	protected function addService(Request $request) {
		DB::beginTransaction();
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:1|max:255',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$parent_id = $request->has('parent') ? $request->input('parent') : 0;
		$service_title = $request->input('title');
		$service_slug = str_slug($service_title);
		$service_link = $request->has('link') ? $request->input('link') : '';
		/*$service_description = $request->has('description') ? $request->input('description') : '';*/
		/*$page_id = $request->has('page') ? $request->input('page') : 0;*/

		$thumb_image = '';
		if($request->hasFile('thumb_image') && $request->file('thumb_image')->isValid()) {
			$image_file = $request->file('thumb_image');
			$image_file_name = $service_slug . '-' . rand(1, 1000000) . '.' . $image_file->getClientOriginalExtension();
			$path = $image_file->move('uploads/service', $image_file_name);
			$thumb_image = $image_file_name;
		}

		$image = '';
		if($request->hasFile('image') && $request->file('image')->isValid()) {
			$image_file = $request->file('image');
			$image_file_name = rand(1, 1000000) . '.' . $image_file->getClientOriginalExtension();
			$path = $image_file->move('uploads/page', $image_file_name);
			$image = $image_file_name;
		}
		$page_content = $request->has('content') ? $request->input('content') : '';

		$service = new Service();
		$service->category_id = 0;
		$service->parent_id = $parent_id;
		$service->service_title = $service_title;
		$service->service_slug = $service_slug;
		$service->thumbnail_image = $thumb_image;
		$service->service_description = '';
		$service->page_id = 0;
		$service->link = $service_link;
		//$service->save();

		$page = new Page();
		$page->title = $service_title;
		$page->slug = $service_slug;
		$page->image = $image;
		$page->content = $page_content;
		$page->status = 1;
		$page->save();

		$service->page_id = $page->id;
		$service->save();

		DB::commit();
		$request->session()->flash('message', 'New service added successfully');
		return redirect()->back();
	}

	protected function editServiceView(Request $request, $service_id) {
		$service = Service::find($service_id);
		if(!$service)
			throw new CustomException("Invalid Service");

		$services = Service::where('id', '<>', $service->id)->where('parent_id', 0)->get();

		$page = $service->page;

		return view('admin.index', [
			'title' => $service->service_title,
			'nav' => 'service',
			'admin_page' => 'service.edit_service',
			'service' => $service,
			'page' => $page,
			'services' => $services,
		]);
	}

	protected function editServiceForm(Request $request, $service_id) {
		$service = Service::find($service_id);
		if(!$service)
			throw new CustomException("Invalid Service");

		$services = Service::where('id', '<>', $service->id)->where('parent_id', 0)->get();

		$pages = Page::where('status', 1)->get();

		$view = view('admin.service.edit_service_form', [
			'service' => $service,
			'services' => $services,
			'pages' => $pages,
		])->render();

		return $view;
	}

	protected function editService(Request $request, $service_id) {
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:1|max:255',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$service = Service::find($service_id);
		if(!$service)
			throw new CustomException("Invalid Service");

		$page = $service->page;

		$service_title = $request->input('title');
		$service_slug = str_slug($service_title);
		$service_link = $request->has('link') ? $request->input('link') : '';
		/*$service_description = $request->has('description') ? $request->input('description') : '';
		$page_id = $request->has('page') ? $request->input('page') : 0;*/

		if($request->hasFile('thumb_image') && $request->file('thumb_image')->isValid()) {
			$image_file = $request->file('thumb_image');
			$image_file_name = $service_slug . '-' . rand(1, 1000000) . '.' . $image_file->getClientOriginalExtension();
			$path = $image_file->move('uploads/service/', $image_file_name);
			$image = $image_file_name;
			if($service->thumbnail_image != '' && \File::exists(public_path('uploads/service/' . $service->thumbnail_image)))
				\File::delete(public_path('uploads/service/' . $service->thumbnail_image));

			$service->thumbnail_image = $image;
		}
		if($request->hasFile('image') && $request->file('image')->isValid()) {
			$image_file = $request->file('image');
			$image_file_name = rand(1, 1000000) . '.' . $image_file->getClientOriginalExtension();
			$path = $image_file->move('uploads/page/', $image_file_name);
			$image = $image_file_name;
			if($page->image != '' && \File::exists(public_path('uploads/page/' . $page->image)))
				\File::delete(public_path('uploads/page/' . $page->image));

			$page->image = $image;
		}
		$content  = $request->has('content') ? $request->input('content') : '';


		$service->service_title = $service_title;
		$service->service_slug = $service_slug;
		/*$service->service_description = $service_description;
		$service->page_id = $page_id;*/
		$service->link = $service_link;
		$service->save();

		$page->title = $service_title;
		$page->slug = $service_slug;
		$page->content = $content;
		$page->save();

		$request->session()->flash('message', 'Service updated successfully');
		return redirect()->back();
	}

	protected function deleteService(Request $request, $service_id) {
		$service = Service::where('id', $service_id)->first();

		if($service->thumbnail_image != '' && \File::exists(public_path('uploads/service/' . $service->thumbnail_image)))
			\File::delete(public_path('uploads/service/' . $service->thumbnail_image));

		$service->delete();

		$request->session()->flash('message', 'Service deleted successfully');
		return redirect()->back();
	}

	protected function makeFeatured(Request $request, $service_id) {
		$service = Service::find($service_id);
		if(!$service)
			throw new CustomException("Invalid Service");

		if($service->featured)
			$service->featured = 0;
		else
			$service->featured = 1;
		$service->save();

		if($request->ajax())
			return response()->json(['status' => 'ok']);
		else {
			$request->session()->flash('message', 'Service \'' . $service->service_title . '\' '. ($service->featured ? "featured" : "unfeatured")  .' successfully');
			return redirect()->back();
		}
	}
}
