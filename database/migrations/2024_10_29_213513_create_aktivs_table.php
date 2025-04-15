<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_street_id')->nullable();
            $table->foreign('sub_street_id')->references('id')->on('sub_streets')->onDelete('cascade');

            $table->unsignedBigInteger('street_id')->nullable(); // Add the street_id column
            $table->foreign('street_id')->references('id')->on('streets')->onDelete('cascade'); // Add foreign key constraint
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('action', ['created', 'updated', 'deleted'])->nullable();
            $table->timestamp('action_timestamp')->nullable();
            $table->softDeletes();

            $table->string('object_name');
            $table->string('balance_keeper');
            $table->string('location');
            $table->decimal('land_area', 10, 2);
            $table->decimal('building_area', 10, 2)->nullable();
            $table->string('gas');
            $table->string('water');
            $table->string('electricity');
            $table->text('additional_info')->nullable();
            $table->string('geolokatsiya');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('kadastr_raqami')->nullable();
            $table->string('status_invest_moderator')->nullable();

            $table->string('kadastr_pdf')->nullable(); // For Kadastr file
            $table->string('hokim_qarori_pdf')->nullable(); // For Hokim qarori file
            $table->string('transfer_basis_pdf')->nullable(); // For transfer basis file

            $table->enum('building_type', ['yer', 'TurarBino', 'NoturarBino'])->nullable();

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
        Schema::dropIfExists('aktivs');
    }
}
