<?php
/**
 * User: suraj
 * Date: 4/9/17
 * Time: 12:48 PM
 */

namespace App\Http\Controllers\Admin;


use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller {

	protected function pages() {
		$pages = Page::all();

		return view('admin.index', [
			'title' => 'Page',
			'nav' => 'page',
			'admin_page' => 'page.all_pages',
			'pages' => $pages
		]);
	}

	protected function addPage() {
		return view('admin.index', [
			'title' => 'Add Page',
			'nav' => 'page',
			'admin_page' => "page.add_page",
		]);
	}

	protected function addPagePost(Request $request) {
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:1|max:255',
		]);

		$page_title = $request->input('title');
		$page_slug = str_slug($page_title);
		$image = '';
		if($request->hasFile('image') && $request->file('image')->isValid()) {
			$image_file = $request->file('image');
			$image_file_name = rand(1, 1000000) . '.' . $image_file->getClientOriginalExtension();
			$path = $image_file->move('uploads/page', $image_file_name);
			$image = $image_file_name;
		}
		$content  = $request->has('content') ? $request->input('content') : '';

		$page = new Page();
		$page->title = $page_title;
		$page->slug = $page_slug;
		$page->image = $image;
		$page->content = $content;
		$page->status = 1;
		$page->save();

		$request->session()->flash('message', 'Page created successfully.');
		return redirect()->route('admin_pages');
	}

	protected function editPage(Request $request, $page_id) {
		$page = Page::find($page_id);
		if(!$page)
			throw new CustomException("Invalid Page");

		return view('admin.index', [
			'title' => $page->title,
			'nav' => 'page',
			'admin_page' => 'page.edit_page',
			'page' => $page,
		]);
	}

	protected function editPagePost(Request $request, $page_id) {
		$page = Page::find($page_id);
		if(!$page)
			throw new CustomException("Invalid Page");

		$validator = Validator::make($request->all(), [
			'title' => 'required|min:1|max:255',
		]);

		$page_title = $request->input('title');
		$page_slug = str_slug($page_title);

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

		$page->title = $page_title;
		$page->slug = $page_slug;
		$page->content = $content;
		$page->save();

		$request->session()->flash('message', 'Page updated successfully.');
		return redirect()->route('admin_pages');
	}

	protected function deletePage(Request $request, $page_id) {
		$page = Page::find($page_id);
		if(!$page_id)
			throw new CustomException("Invalid Page");
		$image = $page->image;
		$page->delete();
		if($image != '' && \File::exists(public_path('uploads/page/' . $image)))
			\File::delete(public_path('uploads/page/' . $image));

		$request->session()->flash('message', 'Page deleted successfully.');
		return redirect()->route('admin_pages');
	}
}