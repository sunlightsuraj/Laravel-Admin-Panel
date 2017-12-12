<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('parent_id')->default(0);
			$table->enum('menu_level', [1, 2, 3])->default(1);
			$table->string('menu_title')->nullable();
			$table->string('menu_slug')->nullable();
			$table->string('menu_link')->nullable();
			$table->enum('link_type', ['internal', 'external'])->default('internal');
			$table->integer('page_id')->default(0);
			$table->string('entity')->nullable()->comment('category, product, service, download');
			$table->integer('position')->default(1);
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
        Schema::dropIfExists('menu');
    }
}
