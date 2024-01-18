<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonProductSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_product_searches', function (Blueprint $table) {
            $table->id();
            $table->string('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_url')->nullable();
            $table->integer('total_reviews')->nullable();
            $table->float('total_rating')->nullable();
            $table->string('company_image')->nullable();
            $table->string('address')->nullable();
            $table->string('company_logo')->default('images/google_logo.png');
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
        Schema::dropIfExists('amazon_product_searches');
    }
}
