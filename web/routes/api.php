<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutScrapeController;

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

Route::post('/outscraper/yelp',[OutScrapeController::class,'yelp_search']);
Route::get('/outscraper/yelp/data',[OutScrapeController::class,'show_yelp_search']);
Route::post('/outscraper/yelp/reviews',[OutScrapeController::class,'yelp_reviews']);
Route::get('/outscraper/yelp/reviews/data',[OutScrapeController::class,'show_yelp_reviews']);
Route::post('/outscraper/yelp/business',[OutScrapeController::class,'yelp_business']);
Route::get('/outscraper/yelp/business/data',[OutScrapeController::class,'show_yelp_business']);
Route::post('/outscraper/amazon/product',[OutScrapeController::class,'amazon_products']);
Route::get('/outscraper/amazon/product/data',[OutScrapeController::class,'show_amazon_product']);
Route::post('/outscraper/amazon/reviews',[OutScrapeController::class,'amazon_reviews']);
Route::get('/outscraper/amazon/reviews/data',[OutScrapeController::class,'show_amazon_reviews']);
Route::post('/outscraper/tripadvisor/reviews',[OutScrapeController::class,'trip_advisor']);
Route::get('/outscraper/tripadvisor/reviews/data',[OutScrapeController::class,'show_tripadvisor_reviews']);
Route::post('/outscraper/facebook',[OutScrapeController::class,'facebook_pages']);
Route::get('/outscraper/facebook/data',[OutScrapeController::class,'show_facebook_page']);
Route::post('/outscraper/facebook/reviews',[OutScrapeController::class,'facebook_reviews']);
Route::get('/outscraper/facebook/reviews/data',[OutScrapeController::class,'show_facebook_reviews']);
Route::post('/outscraper/google',[OutScrapeController::class,'google_map']);
Route::get('/outscraper/google/data',[OutScrapeController::class,'show_google_map']);
Route::post('/outscraper/google/reviews',[OutScrapeController::class,'google_map_reviews']);
Route::get('/outscraper/google/reviews/data',[OutScrapeController::class,'show_google_reviews']);

        }
    );
