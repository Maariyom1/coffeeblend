<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->integer('pro_id')->after('id');
            $table->string('name')->after('pro_id');
            $table->string('image')->after('name');
            $table->decimal('price', 8, 2)->after('image');
            $table->text('description')->after('price');
            $table->unsignedBigInteger('user_id')->after('description');
            $table->integer('quantity')->default(1)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn([
                'pro_id',
                'name',
                'image',
                'price',
                'description',
                'user_id',
                'quantity'
            ]);
        });
    }
}

