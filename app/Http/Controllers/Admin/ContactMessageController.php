<?php

namespace App\Http\Controllers\Admin;

use App\ContactMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactMessageController extends Controller
{
    protected function contactMessages() {
		$contactMessages = ContactMessage::orderBy('created_at', 'desc')->get();

		return view('admin.index', [
			'title' => 'Contact Message',
			'nav' => 'contact',
			'admin_page' => "contact.messages",
			'contactMessages' => $contactMessages
		]);
	}

	protected function deleteMessage(Request $request, $message_id) {
		ContactMessage::where('id', $message_id)->delete();

		$request->session()->flash('message', 'Message deleted successfully');
		return redirect()->back();
	}
}
