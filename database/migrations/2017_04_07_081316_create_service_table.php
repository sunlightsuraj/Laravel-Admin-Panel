<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('parent_id');
			$table->integer('category_id');
			$table->string('service_title');
			$table->string('service_slug');
			$table->string('thumbnail_image')->nullable();
			$table->text('service_description')->nullable();
			$table->integer('page_id')->default(0);
			$table->string('link')->nullable();
			$table->tinyInteger('featured')->default(0);
			$table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('service');
    }
}
