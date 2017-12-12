<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    protected function testimonials() {
		$testimonials = Testimonial::all();

		return view('admin.index', [
			'title' => 'Testimonials',
			'nav' => 'testimonial',
			'admin_page' => 'testimonial.all_testimonials',
			'testimonials' => $testimonials,
		]);
	}

	protected function addTestimonial(Request $request) {
		$validator = Validator::make($request->all(), [
			/*'image' => 'nullable|file|mimes:png,jpg,jpeg,JPG,gif',*/
			'name' => 'nullable|min:1|max:255',
			'message' => 'nullable|min:1',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$image = '';
		if($request->hasFile('image') && $request->file('image')->isValid()) {
			$image_file = $request->file('image');
			$image = 'testimonial-' . rand(1, 10000) . '.' . $image_file->getClientOriginalExtension();
			$image_file->move('uploads/testimonial', $image);
		}
		$name = $request->has('name') ? $request->input('name') : '';
		$message = $request->has('message') ? $request->input('message') : '';

		$testimonial = new Testimonial();
		$testimonial->image = $image;
		$testimonial->name = $name;
		$testimonial->message = $message;
		$testimonial->status = 1;
		$testimonial->save();

		$request->session()->flash('message', 'New testimonial created successfully.');
		return redirect()->back();
	}

	protected function editTestimonial(Request $request) {
		$validator = Validator::make($request->all(), [
			'tid' => 'required|integer|min:1',
			/*'image' => 'nullable|file|mimes:png,jpg,jpeg,JPG,gif',*/
			'name' => 'nullable|min:1|max:255',
			'message' => 'nullable|min:1',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$testimonial_id = $request->input('tid');
		$testimonial = Testimonial::find($testimonial_id);
		if(!$testimonial)
			throw new CustomException("Invalid testimonial");

		if($request->hasFile('image') && $request->file('image')->isValid()) {
			$image_file = $request->file('image');
			$image = 'testimonial-' . rand(1, 10000) . '.' . $image_file->getClientOriginalExtension();
			$image_file->move('uploads/testimonial', $image);
			if($testimonial->image != '' && \File::exists(public_path('uploads/testimonial/' . $testimonial->image)))
				\File::delete('uploads/testimonial/' . $testimonial->image);
			$testimonial->image = $image;
		}
		$name = $request->has('name') ? $request->input('name') : '';
		$message = $request->has('message') ? $request->input('message') : '';

		$testimonial->name = $name;
		$testimonial->message = $message;
		$testimonial->save();

		$request->session()->flash('message', 'Testimonial updated successfully.');
		return redirect()->back();
	}

	protected function deleteTestimonial(Request $request, $testimonial_id) {
		$testimonial = Testimonial::find($testimonial_id);
		if(!$testimonial)
			throw new CustomException("Invalid testimonial.");
		if($testimonial->image != '' && \File::exists(public_path('uploads/testimonial/' . $testimonial->image)))
			\File::delete('uploads/testimonial/' . $testimonial->image);
		$testimonial->delete();

		$request->session()->flash('message', 'Testimonial deleted successfully.');
		return redirect()->back();
	}
}
