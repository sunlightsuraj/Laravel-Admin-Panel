<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';

	public function category() {
		return $this->belongsTo('App\Category', 'category_id');
	}

	public function parent() {
		return $this->belongsTo('App\Service', 'parent_id');
	}

	public function childServices() {
		return $this->hasMany('App\Service', 'parent_id');
	}

	public function page() {
		return $this->belongsTo('App\Page', 'page_id');
	}
}
