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
		Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('transaction_id')->nullable();
			$table->string('name')->nullable();
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->string('amount')->nullable();
			$table->string('currency')->nullable();
			$table->string('payment_status')->nullable();
            $table->string('payment_gateway')->nullable();
			$table->softDeletes();
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
        Schema::dropIfExists('transactions');
    }
};
