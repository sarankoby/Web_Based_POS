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
        Schema::create('final_bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_number')->nullable();
            $table->bigInteger('customer_id')->default(0);
            $table->date('invoice_date')->nullable();
            $table->double('invoice_amount')->default(0);
            $table->double('cash_paid_amount')->default(0);
            $table->double('card_paid_amount')->default(0);
            $table->double('credit_amount')->default(0);
            $table->double('loyality_paid_amount')->default(0);
            $table->double('discount')->default(0);

            $table->bigInteger('auth_id')->unsigned();
            $table->foreign('auth_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('final_bills');
    }
};
