<?php

namespace App\Services;

use App\Interfaces\ProviderInterface;
use App\Models\Provider;
use Illuminate\Support\Facades\Http;

class RainforestService implements ProviderInterface
{
    protected $provider;
    public function __construct()
    {
        $this->provider = Provider::where('name','rainforest')->first();
    }

    public function search($search)
    {

        $queryString = http_build_query([
            'api_key' => $this->provider->access_token,
            'type' => 'search',
            'amazon_domain' => 'amazon.de',
            'refinements' => 'Reviews rating 4 and over',
            'search_term' => trim($search)
        ]);

        $response = Http::withOptions([
            'verify' => false,
            'timeout' => 180,
        ])
            ->get('https://api.rainforest.com/request?' . $queryString);

        $result = $response->json();

        $searchResult = [];
        if (@$result['search_results']){
            foreach ($result['search_results'] as $result){
                $searchResult[] = [
                    'title' => $result['title'],
                    'asin' => $result['asin'],
                    'image' => $result['image'],
                    'url' => $result['link'],
                    'rating' => @$result['rating'],
                    'ratings_total' => @$result['ratings_total'],
                    'price' => @$result['price'],
                    'categories' => @$result['categories'],
                ];
            }
        }
        $data = [
            'results' => @$searchResult,
            'related_searches' => @$result['related_searches'],
            'related_brands' => @$result['related_brands'],
            'pagination' => @$result['pagination'],
        ];

        return $data;
    }

    public function one()
    {
        // TODO: Implement one() method.
    }
}
