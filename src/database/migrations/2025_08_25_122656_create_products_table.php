<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->string('image')->nullable();
            $table->text('description');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('update_at')->useCurrent()->nullable();

            $table->index('name');   // 商品名検索用
            $table->index('price');  // 価格順ソート用
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
