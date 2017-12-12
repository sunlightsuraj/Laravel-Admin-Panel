<?php

namespace App\Http\Controllers\Home;

use App\ContactMessage;
use App\Download;
use App\Exceptions\CustomException;
use App\Menu;
use App\Product;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected function index(Request $request) {
        //$menus = [];
        $products = null;
        $services = null;
        $downloads = null;
        $menus = Menu::where('status', 1)->where('parent_id', 0)->with('childMenus.page')->with('page')->get();
        foreach ($menus as $menu) {
            //$menus[] = $menu->toArray();
            if($menu->entity == 'product' && $products == null)
                $products = Product::where('status', 1)->get();

            else if($menu->entity == 'service' && $services == null)
                $services = Service::where('status', 1)->get();

            else if($menu->entity == 'download' && $downloads == null)
                $downloads = Download::where('status', 1)->get();
        }

        return view('home.index', [
            'title' => env('APP_NAME'),
            'menus' => $menus,
            'products' => $products,
            'services' => $services,
            'downloads' => $downloads
        ]);
    }

    protected function contact(Request $request) {
        $products = null;
        $services = null;
        $downloads = null;
        $menus = Menu::where('status', 1)->where('parent_id', 0)->with('childMenus.page')->with('page')->get();
        foreach ($menus as $menu) {
            //$menus[] = $menu->toArray();
            if($menu->entity == 'product' && $products == null)
                $products = Product::where('status', 1)->get();

            else if($menu->entity == 'service' && $services == null)
                $services = Service::where('status', 1)->get();

            else if($menu->entity == 'download' && $downloads == null)
                $downloads = Download::where('status', 1)->get();
        }

        return view('home.index', [
            'title' => 'Contact | ' . env('APP_NAME'),
            'home_page' => 'contact.contact',
            'menus' => $menus,
            'products' => $products,
            'services' => $services,
            'downloads' => $downloads
        ]);
    }

    protected function contactPost(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|min:1|max:255',
            'phone' => 'required|min:6|max:15',
            'address' => 'max:255',
            'message' => ''
        ]);

        if($validator->fails())
            throw new CustomException(implode("<br>", $validator->errors()->all()));

        $name = $request->input('name');
        $email = $request->input("email");
        $phone = $request->input('phone');
        $address = $request->input('address');
        $message = $request->input('message');

        $contactMessage = new ContactMessage();
        $contactMessage->name = $name;
        $contactMessage->email = $email;
        $contactMessage->phone = $phone;
        $contactMessage->address = $address;
        $contactMessage->message = $message;
        $contactMessage->status = 1;
        $contactMessage->save();

        $request->session()->flash('message', 'Your message submitted successfully.');
        return redirect()->back();
    }
}
