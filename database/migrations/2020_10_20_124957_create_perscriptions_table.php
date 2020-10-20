<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();             // data wystawienia (timestampy)
            //
            // id pacjenta
            $table->unsignedBigInteger('patient_id');
            // id doktora
            $table->unsignedBigInteger('doctor_id');
            // kod dostępu 4 znaki (random generator)
            $table->integer('access_code')->nullable(true)->default(rand(0,9999));
            //  zawartosc (plain text)
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
