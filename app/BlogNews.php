<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogNews extends Model
{
    protected $table = 'blog_news';

	public function page() {
		return $this->belongsTo('App\Page', 'page_id');
	}
}
