<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Exceptions\CustomException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected function categories(Request $request) {
		$categories = Category::withCount('products')->get();

		return view('admin.index', [
			'title' => 'Category',
			'admin_page' => 'category.all_category',
			'categories' => $categories,
			'nav' => 'category',
		]);
	}

	protected function addCategory(Request $request) {
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:1|max:255',
			'description' => 'nullable|min:1',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$title = $request->input('title');
		$slug = str_slug($title);
		$description = $request->input('description');
		$featured_image = '';
		if($request->hasFile('featured_image') && $request->file('featured_image')->isValid()) {
			$featured_image_file = $request->file('featured_image');
			$featured_image = $slug . '-' . rand(1, 10000) . '.' . $featured_image_file->getClientOriginalExtension();
			$featured_image_file->move('uploads/category', $featured_image);
		}

		$category = new Category();
		$category->category_title = $title;
		$category->category_slug = $slug;
		$category->featured_image = $featured_image;
		$category->category_description = $description;
		$category->category_type = 'product';
		$category->status = 1;
		$category->save();

		$request->session()->flash('message', 'Category added successfully.');
		return redirect()->back();
	}

	protected function editCategory(Request $request) {
		$validator = Validator::make($request->all(), [
			'cid' => 'required|integer|min:1',
			'title' => 'required|min:1|max:255',
			'description' => 'nullable|min:1',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$category_id = $request->input('cid');
		$category = Category::find($category_id);
		if(!$category)
			throw new CustomException("Invalid Category");

		$title = $request->input('title');
		$slug = str_slug($title);
		$description = $request->input('description');

		if($request->hasFile('featured_image') && $request->file('featured_image')->isValid()) {
			$featured_image_file = $request->file('featured_image');
			$featured_image = $slug . '-' . rand(1, 10000) . '.' . $featured_image_file->getClientOriginalExtension();
			$featured_image_file->move('uploads/category', $featured_image);
			if($category->featured_image != '' && \File::exists(public_path('uploads/category/' . $category->featured_image)))
				\File::delete(public_path('uploads/category/' . $category->featured_image));

			$category->featured_image = $featured_image;
		}

		$category->category_title = $title;
		$category->category_slug = $slug;
		$category->category_description = $description;
		$category->save();

		$request->session()->flash('message', 'Category updated successfully.');
		return redirect()->back();
	}

	protected function deleteCategory(Request $request, $category_id) {
		$category = Category::find($category_id);
		if(!$category)
			throw new CustomException("Invalid Category");

		if($category->featured_image != '' && \File::exists(public_path('uploads/category/' . $category->featured_image)))
			\File::delete(public_path('uploads/category/' . $category->featured_image));

		$category->delete();

		$request->session()->flash('message', 'Category deleted successfully.');
		return redirect()->back();
	}
}
