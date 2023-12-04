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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('location_id');
            $table->integer('batch_id');
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone_number');
            $table->date('birth_date');
            $table->string('education')->nullable();
            $table->string('city')->nullable();
            $table->string('address');
            $table->string('ktp_file')->nullable();
            $table->string('ijazah_file')->nullable();
            $table->string('jft_status')->nullable();
            $table->string('ssw_status')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('students');
    }
};
