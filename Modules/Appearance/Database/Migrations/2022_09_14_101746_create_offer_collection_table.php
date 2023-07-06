<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_collection', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('url')->nullable();
            $table->string('data_type')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('data_id')->nullable();
            $table->string('offer_image')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('is_newtab')->default(1);
            $table->unsignedInteger('position')->default(598776);
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
        Schema::dropIfExists('offer_collection');
    }
}
