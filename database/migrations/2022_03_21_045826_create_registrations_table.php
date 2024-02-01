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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('sender')->nullable();
            $table->tinyInteger('medium')->nullable();
            $table->string('registration_number')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('letter_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            //$table->string('receiver')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('subject')->nullable();
            /*$table->boolean('confidential')->default(false);
            $table->boolean('urgent')->default(false);*/
            $table->text('remarks')->nullable();
            $table->foreignId('fiscal_year_id');
            $table->foreignId('service_id')->nullable();
            $table->tinyInteger('complete');
            //$table->string('attribute')->nullable();
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
        Schema::dropIfExists('registrations');
    }
};
