<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tem_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quantity');
            $table->double('amount');
            $table->double('discount')->default(0);
            $table->bigInteger('invoice_items_id')->unsigned();
            $table->foreign('invoice_items_id')->references('id')->on('invoice_items')->onDelete('cascade');
            $table->bigInteger('auth_id')->unsigned();
            $table->foreign('auth_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tem_orders');
    }
}
