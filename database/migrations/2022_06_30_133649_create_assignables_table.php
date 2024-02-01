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
        Schema::create('assignables', function (Blueprint $table) {
            $table->morphs('assignable');
            /*$table->foreignId('assignable_id');
            $table->string('assignable_type');*/
            $table->foreignId('document_id');
            $table->string('remarks')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('disapproved_at')->nullable();
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
        Schema::dropIfExists('assignables');
    }
};
