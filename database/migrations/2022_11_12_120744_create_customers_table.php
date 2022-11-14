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
            $table->id();
            $table->string('line_id');
            $table->string('nickname')->nullable();
            $table->tinyInteger('gender', false, true)->nullable();
            $table->integer('age', false, true)->nullable();
            $table->tinyInteger('type', false, true)->nullable();
            $table->tinyInteger('is_followed', false, true)->nullable();
            $table->tinyInteger('is_confirm_send', false, true)->nullable();
            $table->timestamps();
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
