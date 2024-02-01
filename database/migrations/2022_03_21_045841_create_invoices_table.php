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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();
            $table->dateTime('invoice_datetime')->nullable();
            /*$table->string('document_number')->nullable();*/ //redundant
            //$table->string('registration_number')->nullable();
            $table->string('sender')->nullable();
            $table->string('attender_book_number')->nullable();
            $table->string('subject')->nullable();
            $table->string('receiver')->nullable();
            $table->tinyInteger('medium')->nullable(); //Manual, Interconnect, Email
            $table->text('remarks')->nullable();
            $table->foreignId('fiscal_year_id');
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
        Schema::dropIfExists('invoices');
    }
};
