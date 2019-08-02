<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('title')->comment('商品名称');
            $table->text('description')->comment('商品详情');
            $table->string('image')->comment('商品封面图片文件路径');
            $table->boolean('on_sale')->default(true)->comment('商品是否正在售卖');
            $table->unsignedInteger('stock')->default(0)->comment('库存');
            $table->unsignedInteger('sold_count')->default(0)->comment('销量');
            $table->decimal('price', 10, 2)->comment('价格');
            $table->unsignedBigInteger('category_id');
            $table->enum('type',['hot','recommend','common'])->comment('hot=>热销|recommend=>推荐|common=>普通');
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
        Schema::dropIfExists('products');
    }
}
