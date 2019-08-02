<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('province')->comment('省');
            $table->string('city')->comment('市');
            $table->string('district')->comment('区	');
            $table->string('address')->comment('具体地址');
            $table->string('contact_name')->comment('联系人姓名');
            $table->string('contact_phone')->comment('联系人电话');
            $table->boolean('is_check')->comment('默认0，1是选中')->default(0);
            $table->dateTime('last_used_at')->nullable()->comment('最后一次使用时间');
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
        Schema::dropIfExists('user_addresses');
    }
}
