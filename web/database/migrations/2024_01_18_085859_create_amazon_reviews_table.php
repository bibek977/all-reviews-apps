<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author_id')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_url')->nullable();
            $table->integer('review_rating')->nullable();
            $table->string('review_text')->nullable();
            $table->string('review_photos')->nullable();
            $table->string('author_img')->nullable();
            $table->string('review_date')->nullable();
            $table->string('review_badge')->default('images/google_logo.png');
            $table->string('badge_name')->default('Google');
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
        Schema::dropIfExists('amazon_reviews');
    }
}
