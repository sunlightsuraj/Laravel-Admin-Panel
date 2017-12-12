<?php

namespace App\Http\Controllers\Admin;

use App\BlogNews;
use App\Exceptions\CustomException;
use App\News;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    protected function news() {
		$news = BlogNews::all();

		return view('admin.index', [
			'title' => 'News',
			'nav' => 'news',
			'admin_page' => 'news.all_news',
			'news' => $news,
		]);
	}

	protected function addNews(Request $request) {
		return view('admin.index', [
			'title' => 'Add News',
			'nav' => 'news',
			'admin_page' => 'news.add_news',
		]);
	}

	protected function addNewsPost(Request $request) {
		DB::beginTransaction();
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:1|max:255',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$news_title = $request->input('title');
		$news_slug = str_slug($news_title);

		$thumb_image = '';
		if($request->hasFile('thumb_image') && $request->file('thumb_image')->isValid()) {
			$image_file = $request->file('thumb_image');
			$image_file_name = $news_slug . '-' . rand(1, 1000000) . '.' . $image_file->getClientOriginalExtension();
			$path = $image_file->move('uploads/news/', $image_file_name);
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

		$news = new BlogNews();
		$news->title = $news_title;
		$news->slug = $news_slug;
		$news->thumbnail_image = $thumb_image;
		$news->page_id = 0;
		$news->blog_news = 'news';
		$news->status = 1;

		$page = new Page();
		$page->title = $news_title;
		$page->slug = $news_slug;
		$page->image = $image;
		$page->content = $page_content;
		$page->status = 1;
		$page->save();

		$news->page_id = $page->id;
		$news->save();

		DB::commit();
		$request->session()->flash('message', 'News added successfully');
		return redirect()->back();
	}

	protected function editNewsView(Request $request, $news_id) {
		$news = BlogNews::find($news_id);
		if(!$news)
			throw new CustomException("Invalid News");

		$page = $news->page;

		return view('admin.index', [
			'title' => $news->title,
			'nav' => 'news',
			'admin_page' => 'news.edit_news',
			'news' => $news,
			'page' => $page,
		]);
	}


	protected function editNews(Request $request, $news_id) {
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:1|max:255',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$news = BlogNews::find($news_id);
		if(!$news)
			throw new CustomException("Invalid Service");

		$page = $news->page;

		$news_title = $request->input('title');
		$news_slug = str_slug($news_title);

		if($request->hasFile('thumb_image') && $request->file('thumb_image')->isValid()) {
			$image_file = $request->file('thumb_image');
			$image_file_name = $news_slug . '-' . rand(1, 1000000) . '.' . $image_file->getClientOriginalExtension();
			$path = $image_file->move('uploads/news/', $image_file_name);
			$image = $image_file_name;
			if($news->thumbnail_image != '' && \File::exists(public_path('uploads/news/' . $news->thumbnail_image)))
				\File::delete(public_path('uploads/news/' . $news->thumbnail_image));

			$news->thumbnail_image = $image;
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


		$news->title = $news_title;
		$news->slug = $news_slug;
		$news->save();

		$page->title = $news_title;
		$page->slug = $news_slug;
		$page->content = $content;
		$page->save();

		$request->session()->flash('message', 'News updated successfully');
		return redirect()->back();
	}

	protected function deleteNews(Request $request, $news_id) {
		$news = BlogNews::find($news_id);
		if(!$news)
			throw new CustomException("Invalid News");

		if($news->thumbnail_image != '' && \File::exists(public_path('uploads/news/' . $news->thumbnail_image)))
			\File::delete(public_path('uploads/news/' . $news->thumbnail_image));

		$news->delete();

		$request->session()->flash('message', 'News deleted successfully.');
		return redirect()->back();
	}
}
