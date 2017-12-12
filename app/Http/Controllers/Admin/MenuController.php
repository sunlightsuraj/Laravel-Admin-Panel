<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Menu;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    protected function menus(Request $request) {
		/*$menus = Menu::with(['parent', 'page'])->get();*/
        $menus = Menu::where('parent_id', 0)->with(['childMenus' => function ($query) {
            $query->orderBy('position');
        }, 'page'])->orderBy('position')->get();

		$pages = Page::where('status', 1)->get();
		return view('admin.index', [
			'title' => 'Menu',
			'nav' => 'menu',
			'admin_page' => 'menu.all_menu',
			'menus' => $menus,
			'pages' => $pages
		]);
	}

	protected function addMenu(Request $request) {
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:1|max:255',
			'menu_link' => 'nullable',
			'link_type' => 'nullable|in:internal,external',
			'page_id' => 'integer|nullable|min:0',
			'entity' => 'nullable',
			'parent' => 'nullable|integer|min:1',
			'position' => 'integer|min:0',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));

		$menu_title = $request->input('title');
		$menu_slug = str_slug($menu_title);
		$menu_link = $request->has('menu_link') ? $request->input("menu_link") : '';
		$link_type = $request->has('link_type') && in_array($request->input('link_type'), ['internal', 'external']) ? $request->input('link_type') : 'internal';
		$page_id = $request->has('page') ? $request->input('page') : 0;
		$entity = $request->has('entity') ? $request->input('entity') : '';
		$parent_id = $request->has('parent') ? $request->input('parent') : 0;
		$position = 1;
		if($request->has('position') && $request->input('position') > 0) {
			$position = $request->input('position');
			if($position > 0)
				Menu::where('parent_id', $parent_id)->where('position', '>=', $position)->increment('position');
		} else {
			$maxPosition = Menu::where("parent_id", $parent_id)->max('position');
			if($maxPosition)
				$position = $maxPosition + 1;
		}

		$menu = new Menu();
		$menu->parent_id = $parent_id;
		$menu->menu_title = $menu_title;
		$menu->menu_slug = $menu_slug;
		$menu->menu_link = $menu_link;
		$menu->link_type = $link_type;
		$menu->page_id = $page_id;
		$menu->entity = $entity;
		$menu->position = $position;
		$menu->status = 1;
		$menu->save();

		$request->session()->flash('message', 'Menu created successfully.');
		return redirect()->back();
	}

	protected function editMenu(Request $request) {
		$validator = Validator::make($request->all(), [
			'mid' => 'required|integer|min:1',
			'title' => 'required|min:1|max:255',
			'menu_link' => 'nullable',
			'link_type' => 'nullable|in:internal,external',
			'page_id' => 'integer|nullable|min:0',
			'entity' => 'nullable',
			'parent' => 'nullable|integer|min:1',
			'position' => 'integer|min:0',
		]);

		if($validator->fails())
			throw new CustomException(implode("<br>", $validator->errors()->all()));
		$menu_id = $request->input('mid');
		$menu = Menu::find($menu_id);
		if(!$menu)
			throw new CustomException("Invalid Menu");

		$menu_title = $request->input('title');
		$menu_slug = str_slug($menu_title);
		$menu_link = $request->has('menu_link') ? $request->input("menu_link") : '';
		$link_type = $request->has('link_type') && in_array($request->input('link_type'), ['internal', 'external']) ? $request->input('link_type') : 'internal';
		$page_id = $request->has('page') ? $request->input('page') : 0;
		$entity = $request->has('entity') ? $request->input('entity') : '';
		$parent_id = $request->has('parent') ? $request->input('parent') : 0;
		$position = 1;
		if($request->has('position') && $request->input('position') > 0) {
			$position = $request->input('position');
			if($position != $menu->position) {
				Menu::where('parent_id', $parent_id)->where('position', '>', $menu->position)->decrement('position');
				Menu::where('parent_id', $parent_id)->where('position', '>=', $position)->increment('position');
			}
		} else {
			$maxPosition = Menu::where("parent_id", $parent_id)->max('position');
			if($maxPosition)
				$position = $maxPosition + 1;
		}

		$menu->parent_id = $parent_id;
		$menu->menu_title = $menu_title;
		$menu->menu_slug = $menu_slug;
		$menu->menu_link = $menu_link;
		$menu->link_type = $link_type;
		$menu->page_id = $page_id;
		$menu->entity = $entity;
		$menu->position = $position;
		$menu->status = 1;
		$menu->save();

		if($request->ajax()) {
			return response()->json(['status' => 'ok']);
		} else {
			$request->session()->flash('message', 'Menu updated successfully.');
			return redirect()->back();
		}
	}

	protected function deleteMenu(Request $request, $menu_id) {
		DB::beginTransaction();
		$menu = Menu::find($menu_id);
		Menu::where('parent_id', $menu->parent_id)->where('position', '>', $menu->position)->decrement('position');
		$menu->delete();
		DB::commit();
		$request->session()->flash('message', 'Menu deleted successfully.');
		return redirect()->back();
	}
}
