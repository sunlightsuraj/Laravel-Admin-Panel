<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

	public function products() {
		return $this->hasMany('App\Product', 'category_id');
	}

	public function services() {
		return $this->hasMany('App\Service', 'category_id');
	}
}
