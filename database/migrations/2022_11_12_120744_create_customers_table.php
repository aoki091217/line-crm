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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigInteger('customer_id', true, true);
            $table->string('line_token');
            $table->string('name')->nullable();
            $table->tinyInteger('sex', false, true)->nullable();
            $table->integer('generation', false, true)->nullable();
            $table->tinyInteger('reason', false, true)->nullable();
            $table->date('customer_date')->nullable();
            $table->tinyInteger('is_followed', false, true)->nullable();
            $table->tinyInteger('is_confirm_send', false, true)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
