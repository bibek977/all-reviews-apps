<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\YelpBusiness;
use App\Models\YelpReviews;
use App\Models\YelpSearch;
use App\Models\AmazonProductSearch;
use App\Models\AmazonReviews;
use App\Models\TripAdvisorReviews;
use App\Models\FacebookPage;
use App\Models\FacebookPageReviews;
use App\Models\GoogleMap;
use App\Models\GoogleMapReviews;


require_once(base_path('app/outscraper/outscraper.php'));

use App\Outscraper\OutscraperClient;


// To get outscraper key
require __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

$OUTSCRAPER_KEY = isset($_ENV["OUTSCRAPER_KEY"]) ? $_ENV["OUTSCRAPER_KEY"] : null;


class OutscraperController extends Controller
{
  
    public function yelp_search(Request $request){
        $request->validate([
            'description'=>'required',

        ]);
        $client = new OutscraperClient($OUTSCRAPER_KEY);

        $base_url = 'https://www.yelp.com/search?';

        $location_raw = [$request->state];
        $location = implode(' ', $location_raw);
        $description = $request->description;
        $query = $base_url . 'find_desc=' . urlencode($description) . '&find_loc=' . urlencode($location);
        $limit = 2;

        $results = $client->yelp_search($query, $limit,$async_request = FALSE, $webhook = NULL);

        $search_data = $results[0] ?? [];
          
        return response()->json($results[0]);

    } 

    public function yelp_business(Request $request){

        $client = new OutscraperClient($OUTSCRAPER_KEY);

        $request->validate([
            'business_url' => 'required'
        ]);
        $query = $request->business_url;
        
        
        $results = $client->yelp_business($query);

        $search_data = $results ?? [];

        DB::table('yelp_businesses')->truncate();
        foreach ($search_data as $businessData) {
            try {
                DB::table('yelp_businesses')
                    ->updateOrInsert(
                        ['company_id' => $businessData['biz_id']],
                        [
                            'company_name' => $businessData['name'],
                            'company_url' => $businessData['business_url'],
                            'total_reviews' => $businessData['reviews'],
                            'total_rating' => $businessData['rating'],
                            'company_image' => $businessData['photo'],
                            'address' => $businessData['city'],
                            // 'website'=>$businessData['website'],
                        ]
                    );
            } catch (\Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
          
        $limit = 3;
        
        $sort = "rating_asc";
        
        $results = $client->yelp_reviews($query, $limit,$sort);

        $search_data = $results[0] ?? [];
        DB::table('yelp_reviews')->truncate();
        foreach ($search_data as $reviewData) {
            try {
            DB::table('yelp_reviews')
            ->updateOrInsert(
                ['author_id' => $reviewData['author_id']],
                [
                    'author_name' => $reviewData['author_title'],
                    'author_url' => $reviewData['author_url'],
                    'review_rating' => $reviewData['review_rating'],
                    'review_text' => $reviewData['review_text'],
                    'review_photos' => json_encode($reviewData['review_photos']), 
                    'review_date' => $reviewData['date'],
                ]
            );
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        }

        return response()->json($results[0]);

    }   

    public function amazon_products(Request $request) {
        $client = new OutscraperClient($OUTSCRAPER_KEY);
        
        $request->validate([
            'product_desc' => 'required'
        ]);

        $query= $request->product_desc;

        $limit = 3;

        $results = $client->amazon_products($query,$limit);

        $search_data = $results[0] ?? [];

        return response()->json($results[0]);
        
    }

    public function amazon_reviews(Request $request) {
        $client = new OutscraperClient($OUTSCRAPER_KEY);
        
        $request->validate([
            'product_desc' => 'required'
        ]);


        $query= $request->product_desc;

        $limit = 1;

        $results = $client->amazon_products($query,$limit);

        $search_data = $results[0] ?? [];

        DB::table('amazon_product_searches')->truncate();
        foreach ($search_data as $reviewData) {
            try {
            DB::table('amazon_product_searches')
            ->updateOrInsert(
                ['company_id' => $reviewData['asin']],
                [
                    'company_url' => $reviewData['short_url'],
                    'company_name' => $reviewData['store_title'],
                    'address' => $reviewData['name'],
                    'total_reviews' => $reviewData['reviews'],
                    'total_rating' => $reviewData['rating'],
                    'company_image' => $reviewData['image_1'],                 
                ]
            );
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        }

        $limit = 3;

        $results = $client->amazon_reviews($query,$limit);

        $search_data = $results[0] ?? [];

        DB::table('amazon_reviews')->truncate();
        foreach ($search_data as $reviewData) {
            try {
            DB::table('amazon_reviews')
            ->updateOrInsert(
                ['author_id' => $reviewData['id']],
                [                    
                    'review_text' => $reviewData['body'],
                    'review_title' => $reviewData['title'],
                    'review_rating' => $reviewData['rating'],
                    'author_name' => $reviewData['author_title'],
                    'review_date' => $reviewData['date'],
                    'author_url' => $reviewData['author_url'],                    
                    'author_image' => $reviewData['author_profile_img'],                    
                ]
            );
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        }

        return response()->json($results[0]);

    }

    public function youtube_search(Request $request) {
        $client = new OutscraperClient($OUTSCRAPER_KEY);
        
        $request->validate([
            'video_title' => 'required'
        ]);

        $query=$request->video_title;
        $limit = 3;
                

        $results = $client->youtube_search($query,$limit);

        $search_data = $results[0] ?? [];

        return response()->json($results[0]);

    }
    
    public function youtube_channel(Request $request) {
        $client = new OutscraperClient("OGFlZjNlY2UwNDc3NDgyMTk1YTJjYjgwNGUxNTJlMjB8NjU0YzczMmQwMg");
        
        $request->validate([
            'channel_title' => 'required'
        ]);

        $query=$request->channel_title;                

        $results = $client->youtube_channel($query);

        $search_data = $results[0] ?? [];

        return response()->json($results[0]);

    }

    public function youtube_reviews(Request $request) {
        $client = new OutscraperClient($OUTSCRAPER_KEY);
        
        $request->validate([
            'video_title' => 'required'
        ]);

        $query=$request->video_title;
        $limit = 3;
                
        $results = $client->youtube_reviews($query,$limit);

        $search_data = $results[0] ?? [];

        return response()->json($results[0]);

    }
    public function facebook_pages(Request $request) {
        $client = new OutscraperClient($OUTSCRAPER_KEY);
        
        $request->validate([
            'page_title' => 'required'
        ]);

        $query=$request->page_title;

        $fields = "query,page_url,page_name";
                

        $results = $client->facebook_pages($query,$fields);

        $search_data = $results[0] ?? [];

        return response()->json($results);

    }
    public function facebook_reviews(Request $request) {
        $client = new OutscraperClient($OUTSCRAPER_KEY);
        
        $request->validate([
            'page_title' => 'required'
        ]);

        $query=$request->page_title;


        $fields = "query,page_url,page_name";
                

        $results = $client->facebook_pages($query,$fields);

        $search_data = $results ?? [];

        DB::table('facebook_pages')->truncate();
        foreach ($search_data as $reviewData) {
            try {
            DB::table('facebook_pages')
            ->updateOrInsert(
                ['company_id' => $reviewData['id']],
                [
                    'company_name' => $reviewData['name'],
                    'company_url' => $reviewData['link'],
                    'total_reviews' => $reviewData['reviews'],                   
                    'total_rating' => $reviewData['rating'],
                    'company_followers' => $reviewData['followers'],
                    'company_likes' => $reviewData['likes'],
                    'address' => $reviewData['address'],                  
                ]
            );
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        }

        $limit = 3;
        

        $results = $client->facebook_reviews($query,$limit,$fields);

        $search_data = $results[0] ?? [];

        DB::table('facebook_page_reviews')->truncate();
        foreach ($search_data as $reviewData) {
            try {
            DB::table('facebook_page_reviews')
            ->insert(
                [
                    'author_url' => $reviewData['author_link'],  
                    'author_name' => $reviewData['author_title'],  
                    'author_image' => $reviewData['author_image'],  
                    'review_text' => $reviewData['review_text'],  
                    'review_date' => $reviewData['review_date'],  
                    
                ]
            );
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        }

        return response()->json($results[0]);

    }
    public function trip_advisor(Request $request) {
        $client = new OutscraperClient($OUTSCRAPER_KEY);
        
        $request->validate([
            'page_title' => 'required'
        ]);

        $query=$request->page_title;

        $fields = "query,page_url,page_name";
        $limit = 3;
                

        $results = $client->trip_advisor($query,$limit,$fields);

        $search_data = $results[0] ?? [];
        DB::table('trip_advisor_reviews')->truncate();
        foreach ($search_data as $reviewData) {
            try {
            DB::table('trip_advisor_reviews')
            ->updateOrInsert(
                ['author_name' => $reviewData['author_title']],
                [
                    'review_text' => $reviewData['description'],
                    'review_title' => $reviewData['title'],
                    'review_rating' => $reviewData['rating'],
                    'review_date' => $reviewData['reviewed'],   
                    'author_url' => $reviewData['link'],                
                ]
            );
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        }

        return response()->json($results[0]);

    }

    public function google_map(Request $request) {
        $client = new OutscraperClient($OUTSCRAPER_KEY);
        
        $request->validate([
            'place_name' => 'required'
        ]);

        $query=$request->place_name;

        $limit = 3;
                

        $results = $client->google_maps_search($query,$limit);

        $search_data = $results[0] ?? [];

        return response()->json($results[0]);

    }


    public function google_map_reviews(Request $request) {
        $client = new OutscraperClient($OUTSCRAPER_KEY);
        
        $request->validate([
            'google_place_id' => 'required'
        ]);

        
        $query=$request->google_place_id;
        
        $limit = 1;
                

        $results = $client->google_maps_search($query,$limit);

        $search_data = $results[0] ?? [];

        DB::table('google_maps')->truncate();
        foreach ($search_data as $reviewData) {
            try {
            DB::table('google_maps')
            ->updateOrInsert(
                ['company_id' => $reviewData['place_id']],
                [
                    'company_name' => $reviewData['name'],
                    'address' => $reviewData['full_address'],
                    'total_rating' => $reviewData['rating'],
                    'total_reviews' => $reviewData['reviews'],                   
                    'company_image' => $reviewData['photo'],
                    'company_url' => $reviewData['site'],
                ]
            );
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        }

        
        $reviews_limit = 3;
                

        $results = $client->google_maps_reviews($query,$reviews_limit);

        $search_data = $results[0]['reviews_data'] ?? [];


        DB::table('google_map_reviews')->truncate();
        foreach ($search_data as $reviewData) {
            try {
            DB::table('google_map_reviews')
            ->updateOrInsert(
                ['author_id' => $reviewData['author_id']],
                [
                    'author_name' => $reviewData['author_title'],
                    'author_url' => $reviewData['author_link'],
                    'review_rating' => $reviewData['review_rating'],
                    'review_date' => $reviewData['review_datetime_utc'],
                    'review_text' => $reviewData['review_text'],
                    'author_image' => $reviewData['author_image'],
                    'review_photos' => $reviewData['review_img_url'],
                ]
            );
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        }

        return response()->json($results);

    }

    public function show_yelp_search(){
        $search = YelpSearch::all();
        return response()->json($search);
    }
    public function show_yelp_business(){
        $search = YelpBusiness::all();
        return response()->json($search);
    }
    public function show_yelp_reviews(){
        $search = YelpReviews::all();
        return response()->json($search);
    }
    public function show_amazon_product(){
        $search = AmazonProductSearch::all();
        return response()->json($search);
    }
    public function show_amazon_reviews(){
        $search = AmazonReviews::all();
        return response()->json($search);
    }
    public function show_tripadvisor_reviews(){
        $search = TripAdvisorReviews::all();
        return response()->json($search);
    }

    public function show_facebook_page(){
        $search = FacebookPage::all();
        return response()->json($search);
    }
    
    public function show_facebook_reviews(){
        $search = FacebookPageReviews::all();
        return response()->json($search);
    }
    public function show_google_map(){
        $search = GoogleMap::all();
        return response()->json($search);
    }
    public function show_google_reviews(){
        $search = GoogleMapReviews::all();
        return response()->json($search);
    }
}