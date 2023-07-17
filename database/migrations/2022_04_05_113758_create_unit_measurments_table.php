<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitMeasurmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_measurments', function (Blueprint $table) {
            $table->id();
            $table->string('uom')->nullable();
            $table->string('uom_calculation')->nullable();
            $table->string('uom_ereturn')->nullable();
            $table->string('uom_ewaybill')->nullable();
            $table->string('uom_einvoice')->nullable();
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
        Schema::dropIfExists('unit_measurments');
    }
}
