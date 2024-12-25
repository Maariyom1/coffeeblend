<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('country');
            $table->string('state')->nullable(); // Adding state column
            $table->string('streetaddress');
            $table->string('address_line2')->nullable();
            $table->string('towncity');
            $table->string('postcodezip');
            $table->string('phone');
            $table->string('email');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
