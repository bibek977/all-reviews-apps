<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleMapReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_map_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author_id')->unique();
            $table->string('author_name')->nullable();
            $table->string('author_url')->nullable();
            $table->integer('review_rating')->nullable();
            $table->string('review_text')->nullable();
            $table->string('review_photos')->nullable();
            $table->string('author_img')->nullable();
            $table->string('review_date')->nullable();
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
        Schema::dropIfExists('google_map_reviews');
    }
}
