<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    protected function slider() {
		$sliders = Slider::orderBy('position')->get();

		return view('admin.index', [
			'title' => 'Slider',
			'nav' => 'slider',
			'admin_page' => 'slider.all_slider',
			'sliders' => $sliders,
		]);
	}

	protected function addSlider(Request $request) {
		$validator = Validator::make($request->all(), [
			'slider_image' => 'required|file|mimes:png,jpg,jpeg,JPG,gif',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$slider = new Slider();

		if($request->hasFile('slider_image') && $request->file('slider_image')->isValid()) {
			$slider_image = $request->file('slider_image');
			$image_name = rand(1, 1000000) . '.' . $slider_image->getClientOriginalExtension();
			$slider_image->move(public_path('uploads/slider/'), $image_name);
			$slider->slider_image = $image_name;
		} else {
			throw new CustomException("Please select a valid image.");
		}

		$slider->slider_title = $request->has('title') ? $request->input('title') : '';
		$slider->slider_caption = $request->has('caption') ? $request->input('caption') : '';

		$position = 1;
		if($request->has('position')) {
			$position = $request->input('position');
			Slider::where('position', '>=', $position)->increment('position');
		} else {
			$max_position = Slider::where('status', 1)->max('position');
			if($max_position)
				$position = $max_position + 1;
		}
		$slider->position = $position;
		$slider->save();

		$request->session()->flash('message', 'Slider added successfully');
		return redirect()->back();
	}

	protected function editSliderForm(Request $request, $slider_id) {
		$slider = Slider::find($slider_id);
		if(!$slider)
			throw new CustomException("Invalid Slider");

		$view = view('admin.slider.slider_edit_form', ['slider' => $slider])->render();
		return $view;
	}

	protected function editSlider(Request $request, $slider_id) {
		$validator = Validator::make($request->all(), [
			'slider_image' => 'file|mimes:png,jpg,jpeg,JPG,gif',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$slider = Slider::find($slider_id);
		if(!$slider)
			throw new CustomException("Invalid Slider");

		if($request->hasFile('slider_image') && $request->file('slider_image')->isValid()) {
			$slider_image = $request->file('slider_image');
			$image_name = rand(1, 1000000) . '.' . $slider_image->getClientOriginalExtension();
			$slider_image->move(public_path('uploads/slider/'), $image_name);
			$pre_image = $slider->slider_image;
			$slider->slider_image = $image_name;
			if($pre_image != '' && \File::exists(public_path('uploads/slider/' . $pre_image)))
				\File::delete(public_path('uploads/slider/' . $pre_image));
		}

		$slider->slider_title = $request->has('title') ? $request->input('title') : '';
		$slider->slider_caption = $request->has('caption') ? $request->input('caption') : '';


		$position = $slider->position;
		if($request->has('position')) {
			$position = $request->input('position');
			if($position != $slider->position) {
				Slider::where('position', '>', $slider->position)->decrement('position');
				Slider::where('position', '>=', $position)->increment('position');
			}
		} else {
			$max_position = Slider::where('status', 1)->max('position');
			if($max_position)
				$position = $max_position + 1;
		}
		$slider->position = $position;
		$slider->save();

		if($request->ajax()) {
			return response()->json(['status' => 'ok']);
		} else {
			$request->session()->flash('message', 'Slider updated successfully');
			return redirect()->back();
		}
	}

	protected function deleteSlider(Request $request, $slider_id) {
		$slider = Slider::where('id', $slider_id)->first();
		$position = $slider->position;
		Slider::where('position', '>', $position)->decrement('position');
		$slider->delete();
		$request->session()->flash('message', 'Slider deleted successfully');
		return redirect()->back();
	}
}
