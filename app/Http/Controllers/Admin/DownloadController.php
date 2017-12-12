<?php
/**
 * User: suraj
 * Date: 4/10/17
 * Time: 2:46 PM
 */

namespace App\Http\Controllers\Admin;


use App\Download;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DownloadController extends Controller {
	protected function downloads() {
		$downloads = Download::all();

		return view('admin.index', [
			'title' => 'Download',
			'nav' => "download",
			'admin_page' => 'download.all_downloads',
			'downloads' => $downloads
		]);
	}

	protected function addDownload(Request $request) {
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:1|max:255',
			'link' => 'nullable|min:1|max:255',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$title = $request->input('title');
		$slug = str_slug($title);
		$file = '';
		if($request->hasFile('file') && $request->file('file')->isValid()) {
			$download_file = $request->file('file');
			$file = $slug . '-' . rand(1, 10000) . '.' . $download_file->getClientOriginalExtension();
			$download_file->move('uploads/download', $file);
		}
		$link = $request->has('link') ? $request->input('link') : '';

		$download = new Download();
		$download->download_title = $title;
		$download->download_slug = $slug;
		$download->download_file = $file;
		$download->download_link = $link;
		$download->status = 1;
		$download->save();

		$request->session()->flash('message', 'Download added successfully.');
		return redirect()->back();
	}

	protected function editDownload(Request $request) {
		$validator = Validator::make($request->all(), [
			'did' => 'required|integer|min:1',
			'title' => 'required|min:1|max:255',
			'link' => 'nullable|min:1|max:255',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$download_id = $request->input('did');
		$download = Download::find($download_id);
		if(!$download)
			throw new CustomException("Invalid download");

		$title = $request->input('title');
		$slug = str_slug($title);

		if($request->hasFile('file') && $request->file('file')->isValid()) {
			$download_file = $request->file('file');
			$file = $slug . '-' . rand(1, 10000) . '.' . $download_file->getClientOriginalExtension();
			$download_file->move('uploads/download', $file);
			if($download->download_file != '' && \File::exists(public_path('uploads/download/' . $download->download_file)))
				\File::delete(public_path('uploads/download/' . $download->download_file));
			$download->download_file = $file;
		}
		$link = $request->has('link') ? $request->input('link') : '';

		$download->download_title = $title;
		$download->download_slug = $slug;
		$download->download_link = $link;
		$download->save();

		$request->session()->flash('message', 'Download updated successfully.');
		return redirect()->back();
	}

	protected function deleteDownload(Request $request, $download_id) {
		$download = Download::find($download_id);
		if(!$download)
			throw new CustomException("Invalid Download");
		if($download->download_file != '' && \File::exists(public_path('uploads/download/' . $download->download_file))) {
			\File::delete(public_path('uploads/download/' . $download->download_file));
		}
		$download->delete();

		$request->session()->flash('message', 'Download deleted successfully.');
		return redirect()->back();
	}
}