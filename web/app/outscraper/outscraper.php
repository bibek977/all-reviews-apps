<?php

namespace App\Outscraper;

class OutscraperClient {
    public $version = "3.2.0";
    private $api_url = "https://api.app.outscraper.com";
    private $api_headers;
    private $max_ttl = 60 * 60;
    private $requests_pause = 5;


    public function __construct(string $api_key = NULL, int $requests_pause = 5) {
        if($api_key == NULL)
            throw new Exception("api_key must have a value");

        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Client: PHP SDK {$this->version}";
        $headers[] = "X-API-KEY: {$api_key}";

        $this->api_headers = $headers;
        $this->requests_pause = $requests_pause;
    }

    private function wait_request_archive(string $request_id) : array {
        $ttl = $this->max_ttl / $this->requests_pause;

        while ($ttl > 0) {
            $ttl--;
            sleep($this->requests_pause);

            $result = $this->get_request_archive($request_id);
            if ($result["status"] != "Pending") {
                return $result;
            }
        }

        throw new Exception("Timeout exceeded");
    }

    private function make_get_request(string $url) : array {
        $url = preg_replace('/%5B[0-9]+%5D/simU', '', $url);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "{$this->api_url}/{$url}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->api_headers);

        $result = json_decode(curl_exec($ch), true);
        if (curl_errno($ch)) {
            throw new Exception("API Error: " . curl_error($ch));
        }
        curl_close($ch);

        if (array_key_exists("error", $result) && $result["error"] == TRUE) {
            throw new Exception($result["errorMessage"]);
        }

        return $result;
    }

    private function to_array(string|array $value) : array {
        if (is_array($value)) {
            return $value;
        } else {
            return [$value];
        }
    }


    public function get_requests_history() : array {
        return $this->make_get_request("requests");
    }


    public function get_request_archive(string $request_id) : array {
        if($request_id == NULL)
            throw new Exception("request_id must have a value");
        return $this->make_get_request("requests/{$request_id}");
    }


    public function yelp_reviews(
        string|array $query,int $limit = 3, string $sort,  bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "sort" => $sort,
            "limit" => $limit,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("yelp/reviews?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }
  
    public function yelp_search(
        string|array $query,int $limit = 2,  bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "limit" => $limit,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("yelp-search?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }

    public function yelp_business(
        string|array $query, bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("yelp-biz?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }

    public function amazon_products(
        string|array $query,int $limit = 3,  bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "limit" => $limit,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("amazon/products?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }

    public function amazon_reviews(
        string|array $query,int $limit = 3,  bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "limit" => $limit,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("amazon/reviews?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }
 
    public function youtube_search(
        string|array $query,int $limit = 3,  bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "limit" => $limit,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("youtube-search?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }
    
    public function youtube_channel(
        string|array $query, bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("youtube-channel?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }

    public function youtube_reviews(
        string|array $query,int $limit = 3,  bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "perQuery" => $limit,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("youtube-comments?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }

    public function facebook_pages(
        string|array $query,string|array $fields,  bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("facebook/pages?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }
    public function facebook_reviews(
        string|array $query,int $limit = 3,string|array $fields,  bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "async" => $async_request,
            "limit" => $limit,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("facebook/reviews?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }

    public function trip_advisor(
        string|array $query,int $limit = 3,string|array $fields,  bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {

        $params = http_build_query(array(
            "query" => $query,
            "async" => $async_request,
            "limit" => $limit,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("tripadvisor/reviews?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }

    public function google_maps_search(
        string|array $query, string $language = "en", string $region = NULL, int $limit = 3,
        string $coordinates = NULL, bool $drop_duplicates = FALSE, int $skip = 0, bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {
        $params = http_build_query(array(
            "query" => $query,
            "language" => $language,
            "region" => $region,
            "limit" => $limit,
            "coordinates" => $coordinates,
            "dropDuplicates" => $drop_duplicates,
            "skipPlaces" => $skip,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("maps/search-v3?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }

    public function google_maps_reviews(
        string|array $query, string $language = "en", string $region = NULL, int $limit = 1,
        int $reviews_limit = 3, string $coordinates = NULL, int $cutoff = NULL, int $cutoff_rating = NULL,
        string $sort = "most_relevant", string $reviews_query = NULL, bool $ignore_empty = FALSE,
        string $last_pagination_id = NULL, bool $async_request = FALSE, string $webhook = NULL
    ) : array|string {
        $params = http_build_query(array(
            "query" => $query,
            "language" => $language,
            "region" => $region,
            "limit" => $limit,
            "reviewsLimit" => $reviews_limit,
            "coordinates" => $coordinates,
            "cutoff" => $cutoff,
            "cutoffRating" => $cutoff_rating,
            "sort" => $sort,
            "reviewsQuery" => $reviews_query,
            "ignoreEmpty" => $ignore_empty,
            "lastPaginationId" => $last_pagination_id,
            "async" => $async_request,
            "webhook" => $webhook,
        ));
        $result = $this->make_get_request("maps/reviews-v3?{$params}");

        if($async_request)
            return $result;

        return $result["data"];
    }
    
}

?>