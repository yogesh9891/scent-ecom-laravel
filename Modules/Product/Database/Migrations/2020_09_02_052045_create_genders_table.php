<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("logo")->nullable();
            $table->text("description")->nullable();
            $table->string("link")->nullable();
            $table->boolean("status")->default(1);
            $table->boolean("featured")->default(0);
            $table->text("meta_title")->nullable();
            $table->text("meta_description")->nullable();
            $table->unsignedBigInteger("sort_id")->nullable();
            $table->unsignedBigInteger('total_sale')->default(0);
            $table->integer('avg_rating')->default(0);
            $table->string("slug")->nullable();
            $table->unsignedBigInteger("created_by")->nullable();
            $table->foreign("created_by")->on("users")->references("id")->onDelete("cascade");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->foreign("updated_by")->on("users")->references("id")->onDelete("cascade");
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
        Schema::dropIfExists('genders');
    }
}
