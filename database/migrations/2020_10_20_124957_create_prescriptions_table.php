<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // patient ID
            $table->unsignedBigInteger('patient_id');
            // doctor ID
            $table->unsignedBigInteger('doctor_id');
            // access code 4 digit (random generator)
            $table->integer('access_code')->nullable(true)->default(rand(0,9999));
            //  content (plain text)
            $table->text('content')->default("Brak zawartości");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perscriptions');
    }
}
