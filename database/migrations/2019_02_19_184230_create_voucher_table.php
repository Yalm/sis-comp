<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->integer('payment_voucher_id')->unsigned();
            $table->foreign('payment_voucher_id')->references('id')->on('voucher_types');

            $table->string('serie',4);
            $table->string('number',8);
            $table->text('link');
            $table->boolean('actived')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
