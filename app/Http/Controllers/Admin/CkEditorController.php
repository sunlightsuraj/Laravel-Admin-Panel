<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CkEditorController extends Controller
{
    protected function uploadImage(Request $request) {
		$validator = Validator::make($request->all(), [
			'upload' => 'required|file|mimes:jpg,jpeg,JPG,png,gif'
		]);

		if($validator->fails())
			return response()->json(['upload' => 0, 'error' => $validator->errors()->all()]);

		if($request->hasFile('upload') && $request->file('upload')->isValid()) {
			$upload_file = $request->file('upload');
			$upload_file_name = rand(1, 100000) . '.' . $upload_file->getClientOriginalExtension();
			$path = $upload_file->move(public_path('uploads/ckuploads'), $upload_file_name);

			return response()->json(['uploaded' => 1, 'fileName' => $upload_file_name, 'url' => url('uploads/ckuploads/' . $upload_file_name)]);
		}

	}
}
