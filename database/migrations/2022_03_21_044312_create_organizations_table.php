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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('name');
            $table->string('email');
            $table->tinyInteger('address_type')->default(0);
            /*  Address Area Start

                Type 0 = Default Address
                Type 1 = Municipal Body Address
                Type 2 = District Body Address
                Type 3 = Provincial Body Address
                Type 4 = State Body Address

            Field under this section should be filled only on the basis of organization body type.
            Only one field should be filled, other should be left null based on type column.
            */
            $table->string('address')->nullable();
            $table->foreignId('municipality_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreignId('province_id')->nullable();
            /*Address Area End*/
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
        Schema::dropIfExists('organizations');
    }
};
