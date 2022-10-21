<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_bill_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bill_id')->unsigned();
            $table->foreign('bill_id')->references('id')->on('final_bills')->onDelete('cascade');
            $table->bigInteger('quantity');
            $table->double('amount');
            $table->double('discount')->default(0);
            $table->bigInteger('invoice_items_id')->unsigned();
            $table->foreign('invoice_items_id')->references('id')->on('invoice_items');
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
        Schema::dropIfExists('final_bill_items');
    }
};
