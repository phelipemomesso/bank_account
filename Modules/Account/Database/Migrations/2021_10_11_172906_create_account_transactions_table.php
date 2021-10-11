<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('account_id');
            $table->foreign('account_id')->references('id')->on('account_accounts');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->char('type',1)->comment('C-Credit / D-Debit');
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
        Schema::dropIfExists('account_transactions');
    }
}
