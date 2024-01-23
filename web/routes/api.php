<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutscraperController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return "Hello API";
});


Route::middleware(['shopify.auth'])->group(
    function () {

Route::post('/outscraper/yelp',[OutscraperController::class,'yelp_search']);
Route::get('/outscraper/yelp/data',[OutscraperController::class,'show_yelp_search']);
Route::post('/outscraper/yelp/reviews',[OutscraperController::class,'yelp_reviews']);
Route::get('/outscraper/yelp/reviews/data',[OutscraperController::class,'show_yelp_reviews']);
Route::post('/outscraper/yelp/business',[OutscraperController::class,'yelp_business']);
Route::get('/outscraper/yelp/business/data',[OutscraperController::class,'show_yelp_business']);
Route::post('/outscraper/amazon/product',[OutscraperController::class,'amazon_products']);
Route::get('/outscraper/amazon/product/data',[OutscraperController::class,'show_amazon_product']);
Route::post('/outscraper/amazon/reviews',[OutscraperController::class,'amazon_reviews']);
Route::get('/outscraper/amazon/reviews/data',[OutscraperController::class,'show_amazon_reviews']);
Route::post('/outscraper/tripadvisor/reviews',[OutscraperController::class,'trip_advisor']);
Route::get('/outscraper/tripadvisor/reviews/data',[OutscraperController::class,'show_tripadvisor_reviews']);
Route::post('/outscraper/facebook',[OutscraperController::class,'facebook_pages']);
Route::get('/outscraper/facebook/data',[OutscraperController::class,'show_facebook_page']);
Route::post('/outscraper/facebook/reviews',[OutscraperController::class,'facebook_reviews']);
Route::get('/outscraper/facebook/reviews/data',[OutscraperController::class,'show_facebook_reviews']);
Route::post('/outscraper/google',[OutscraperController::class,'google_map']);
Route::get('/outscraper/google/data',[OutscraperController::class,'show_google_map']);
Route::post('/outscraper/google/reviews',[OutscraperController::class,'google_map_reviews']);
Route::get('/outscraper/google/reviews/data',[OutscraperController::class,'show_google_reviews']);
Route::get('/outscraper/social/data',[OutscraperController::class,'show_social_platforms']);
        }
    );
