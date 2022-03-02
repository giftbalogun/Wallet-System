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
		Schema::create('wallets_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amount');
            $table->string('user_id');
			$table->string('trans_id');
            $table->string('isinflow')->nullable();
			$table->string('payment_method')->nullable();
			$table->string('currency')->nullable();
			$table->string('status')->nullable();
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
        Schema::dropIfExists('wallets_transactions');
    }
};
