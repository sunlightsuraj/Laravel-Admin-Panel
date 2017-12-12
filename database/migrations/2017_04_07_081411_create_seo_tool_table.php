<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoToolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_tool', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('parent_id');
			$table->enum('parent_type', ['category', 'product', 'service'])->default('category');
			$table->text('meta_keywords')->nullable();
			$table->text('meta_description')->nullable();
			$table->text('page_title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_tool');
    }
}
