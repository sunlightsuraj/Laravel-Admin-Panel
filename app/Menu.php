<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

	public function parent() {
		return $this->belongsTo('App\Menu', 'parent_id');
	}

	public function childMenus() {
		return $this->hasMany('App\Menu', 'parent_id');
	}

	public function page() {
		return $this->belongsTo('App\Page', 'page_id');
	}
}
