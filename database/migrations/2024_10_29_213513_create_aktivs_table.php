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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // Basic information
            $table->string('lot_number')->nullable();
            $table->string('object_name');
            $table->string('balance_keeper')->nullable();
            $table->string('location');
            $table->decimal('land_area', 10, 2)->default(0);
            $table->decimal('building_area', 10, 2)->nullable();
            $table->enum('building_type', ['yer', 'TurarBino', 'NoturarBino'])->default('yer');
            $table->text('building_type_comment')->nullable();
            // Auction and price information
            $table->decimal('start_price', 20, 2)->nullable();
            $table->decimal('sold_price', 20, 2)->nullable();
            $table->dateTime('auction_date')->nullable();
            $table->string('winner_name')->nullable();
            $table->string('winner_phone')->nullable();
            $table->string('payment_type')->nullable();

            // Technical information
            $table->string('zone')->nullable();
            $table->string('kadastr_raqami')->nullable();
            $table->string('geolokatsiya')->nullable();
            $table->integer('latitude');
            $table->integer('longitude');

            // Additional information
            $table->string('gas')->default('Yes');
            $table->string('water')->default('Yes');
            $table->string('electricity')->default('Yes');
            $table->string('auction_status')->nullable();
            $table->text('additional_info')->nullable();

            // Investment details
            $table->decimal('investment_amount', 20, 2)->nullable();
            $table->integer('job_creation_count')->nullable();

            // External links
            $table->string('lot_link')->nullable();
            $table->string('main_image')->nullable();

            // Document uploads
            $table->string('kadastr_pdf')->nullable();
            $table->string('hokim_qarori_pdf')->nullable();
            $table->string('transfer_basis_pdf')->nullable();

            // Relations
            $table->unsignedBigInteger('sub_street_id')->nullable();
            $table->foreign('sub_street_id')->references('id')->on('sub_streets')->onDelete('set null');
            $table->unsignedBigInteger('street_id')->nullable();
            $table->foreign('street_id')->references('id')->on('streets')->onDelete('set null');

            // Tracking
            $table->string('status_invest_moderator')->nullable();
            $table->enum('action', ['created', 'updated', 'deleted'])->nullable();
            $table->timestamp('action_timestamp')->nullable();

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
        Schema::dropIfExists('aktivs');
    }
}
