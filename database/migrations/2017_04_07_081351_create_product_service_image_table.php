<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductServiceImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_service_image', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('parent_id');
			$table->enum('parent_type', ['product', 'service'])->default('product');
			$table->string('image');
			$table->tinyInteger('status')->defualt(1);
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
        Schema::dropIfExists('product_service_image');
    }
}
