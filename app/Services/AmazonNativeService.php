<?php

namespace App\Services;

use App\Helpers\AwsV4;
use App\Interfaces\ProviderInterface;
use App\Models\Provider;

class AmazonNativeService implements ProviderInterface
{
    protected $provider;
    public function __construct()
    {
        $this->provider = Provider::where('name','amazon_native')->first();
    }

    public function search($search)
    {
        $product_search_key = $search;
        $payload = $this->buildPayload($product_search_key);
        $headers = $this->buildHeaders($payload);
        $response = $this->sendRequest($headers, $payload);
        $searchResult = $this->parseResponse($response);

        $data = [
            'results' => $searchResult,
            'related_searches' =>null,
            'related_brands' => null,
            'pagination' => null,
        ];

        return $data;
    }

    private function buildPayload($searchKey)
    {
        return json_encode([
            "Keywords" => $searchKey,
            "Resources" => [
                "BrowseNodeInfo.BrowseNodes",
                "BrowseNodeInfo.BrowseNodes.Ancestor",
                "BrowseNodeInfo.BrowseNodes.SalesRank",
                "BrowseNodeInfo.WebsiteSalesRank",
                "CustomerReviews.Count",
                "CustomerReviews.StarRating",
                "Images.Primary.Small",
                "Images.Primary.Medium",
                "Images.Primary.Large",
                "Images.Primary.HighRes",
                "Images.Variants.Small",
                "Images.Variants.Medium",
                "Images.Variants.Large",
                "Images.Variants.HighRes",
                "ItemInfo.ByLineInfo",
                "ItemInfo.ContentInfo",
                "ItemInfo.ContentRating",
                "ItemInfo.Classifications",
                "ItemInfo.ExternalIds",
                "ItemInfo.Features",
                "ItemInfo.ManufactureInfo",
                "ItemInfo.ProductInfo",
                "ItemInfo.TechnicalInfo",
                "ItemInfo.Title",
                "ItemInfo.TradeInInfo",
                "Offers.Listings.Availability.MaxOrderQuantity",
                "Offers.Listings.Availability.Message",
                "Offers.Listings.Availability.MinOrderQuantity",
                "Offers.Listings.Availability.Type",
                "Offers.Listings.Condition",
                "Offers.Listings.Condition.ConditionNote",
                "Offers.Listings.Condition.SubCondition",
                "Offers.Listings.DeliveryInfo.IsAmazonFulfilled",
                "Offers.Listings.DeliveryInfo.IsFreeShippingEligible",
                "Offers.Listings.DeliveryInfo.IsPrimeEligible",
                "Offers.Listings.DeliveryInfo.ShippingCharges",
                "Offers.Listings.IsBuyBoxWinner",
                "Offers.Listings.LoyaltyPoints.Points",
                "Offers.Listings.MerchantInfo",
                "Offers.Listings.Price",
                "Offers.Listings.ProgramEligibility.IsPrimeExclusive",
                "Offers.Listings.ProgramEligibility.IsPrimePantry",
                "Offers.Listings.Promotions",
                "Offers.Listings.SavingBasis",
                "Offers.Summaries.HighestPrice",
                "Offers.Summaries.LowestPrice",
                "Offers.Summaries.OfferCount",
                "ParentASIN",
                "RentalOffers.Listings.Availability.MaxOrderQuantity",
                "RentalOffers.Listings.Availability.Message",
                "RentalOffers.Listings.Availability.MinOrderQuantity",
                "RentalOffers.Listings.Availability.Type",
                "RentalOffers.Listings.BasePrice",
                "RentalOffers.Listings.Condition",
                "RentalOffers.Listings.Condition.ConditionNote",
                "RentalOffers.Listings.Condition.SubCondition",
                "RentalOffers.Listings.DeliveryInfo.IsAmazonFulfilled",
                "RentalOffers.Listings.DeliveryInfo.IsFreeShippingEligible",
                "RentalOffers.Listings.DeliveryInfo.IsPrimeEligible",
                "RentalOffers.Listings.DeliveryInfo.ShippingCharges",
                "RentalOffers.Listings.MerchantInfo",
                "SearchRefinements",
            ],
            "SearchIndex" => "All",
            "PartnerTag" => "cookwarespa0a-20",
            "PartnerType" => "Associates",
            "ItemCount" => 10,
            "LanguagesOfPreference" => ["en_US"],
            "MinReviewsRating" => 4,
            "CurrencyOfPreference" => "EUR",
            "Marketplace" => "www.amazon.com"
        ]);
    }

    private function buildHeaders($payload)
    {
        $serviceName = "ProductAdvertisingAPI";
        $region = "us-east-1";
        $accessKey = $this->provider->access_token;
        $secretKey = $this->provider->access_secret;
        $host = "webservices.amazon.com";
        $uriPath = "/paapi5/searchitems";

        $awsv4 = new AwsV4($accessKey, $secretKey);
        $awsv4->setRegionName($region);
        $awsv4->setServiceName($serviceName);
        $awsv4->setPath($uriPath);
        $awsv4->setPayload($payload);
        $awsv4->setRequestMethod("POST");
        $awsv4->addHeader('content-encoding', 'amz-1.0');
        $awsv4->addHeader('content-type', 'application/json; charset=utf-8');
        $awsv4->addHeader('host', $host);
        $awsv4->addHeader('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems');

        return $awsv4->getHeaders();
    }

    private function sendRequest($headers, $payload)
    {
        $params = [
            'http' => [
                'header' => implode("\r\n", array_map(
                    function ($key, $value) {
                        return "$key: $value";
                    },
                    array_keys($headers),
                    array_values($headers)
                )),
                'method' => 'POST',
                'content' => $payload
            ]
        ];

        $stream = stream_context_create($params);
        $fp = @fopen('https://webservices.amazon.com/paapi5/searchitems', 'rb', false, $stream);
        $response = @stream_get_contents($fp);

        return json_decode($response, true);
    }

    private function parseResponse($response)
    {
        $searchResult = [];

        if (isset($response['SearchResult']['Items'])) {
            foreach ($response['SearchResult']['Items'] as $result) {
                $searchResult[] = [
                    'title' => $result['ItemInfo']['Title']['DisplayValue'],
                    'asin' => $result['ASIN'],
                    'image' => $result['Images']['Primary']['Medium']['URL'],
                    'url' => $result['DetailPageURL'],
                    'rating' => 4,
                    'ratings_total' => null,
                    'price' => [
                        'value' => @$result['Offers']['Summaries'][0]['LowestPrice']['Amount'],
                        'symbol' => @$result['Offers']['Summaries'][0]['LowestPrice']['Currency'],
                        'raw' => @$result['Offers']['Summaries'][0]['LowestPrice']['DisplayAmount'],
                    ],
                    'categories' => null,
                ];
            }
        }

        return $searchResult;
    }




    public function search2($search)
    {
        $product_search_key = $search;
        $serviceName="ProductAdvertisingAPI";
        $region="us-east-1";
        $accessKey=$this->provider->access_token;
        $secretKey=$this->provider->access_secret;
        $payload="{"
            ." \"Keywords\": \"$product_search_key\","
            ." \"Resources\": ["
            ."  \"BrowseNodeInfo.BrowseNodes\","
            ."  \"BrowseNodeInfo.BrowseNodes.Ancestor\","
            ."  \"BrowseNodeInfo.BrowseNodes.SalesRank\","
            ."  \"BrowseNodeInfo.WebsiteSalesRank\","
            ."  \"CustomerReviews.Count\","
            ."  \"CustomerReviews.StarRating\","
            ."  \"Images.Primary.Small\","
            ."  \"Images.Primary.Medium\","
            ."  \"Images.Primary.Large\","
            ."  \"Images.Primary.HighRes\","
            ."  \"Images.Variants.Small\","
            ."  \"Images.Variants.Medium\","
            ."  \"Images.Variants.Large\","
            ."  \"Images.Variants.HighRes\","
            ."  \"ItemInfo.ByLineInfo\","
            ."  \"ItemInfo.ContentInfo\","
            ."  \"ItemInfo.ContentRating\","
            ."  \"ItemInfo.Classifications\","
            ."  \"ItemInfo.ExternalIds\","
            ."  \"ItemInfo.Features\","
            ."  \"ItemInfo.ManufactureInfo\","
            ."  \"ItemInfo.ProductInfo\","
            ."  \"ItemInfo.TechnicalInfo\","
            ."  \"ItemInfo.Title\","
            ."  \"ItemInfo.TradeInInfo\","
            ."  \"Offers.Listings.Availability.MaxOrderQuantity\","
            ."  \"Offers.Listings.Availability.Message\","
            ."  \"Offers.Listings.Availability.MinOrderQuantity\","
            ."  \"Offers.Listings.Availability.Type\","
            ."  \"Offers.Listings.Condition\","
            ."  \"Offers.Listings.Condition.ConditionNote\","
            ."  \"Offers.Listings.Condition.SubCondition\","
            ."  \"Offers.Listings.DeliveryInfo.IsAmazonFulfilled\","
            ."  \"Offers.Listings.DeliveryInfo.IsFreeShippingEligible\","
            ."  \"Offers.Listings.DeliveryInfo.IsPrimeEligible\","
            ."  \"Offers.Listings.DeliveryInfo.ShippingCharges\","
            ."  \"Offers.Listings.IsBuyBoxWinner\","
            ."  \"Offers.Listings.LoyaltyPoints.Points\","
            ."  \"Offers.Listings.MerchantInfo\","
            ."  \"Offers.Listings.Price\","
            ."  \"Offers.Listings.ProgramEligibility.IsPrimeExclusive\","
            ."  \"Offers.Listings.ProgramEligibility.IsPrimePantry\","
            ."  \"Offers.Listings.Promotions\","
            ."  \"Offers.Listings.SavingBasis\","
            ."  \"Offers.Summaries.HighestPrice\","
            ."  \"Offers.Summaries.LowestPrice\","
            ."  \"Offers.Summaries.OfferCount\","
            ."  \"ParentASIN\","
            ."  \"RentalOffers.Listings.Availability.MaxOrderQuantity\","
            ."  \"RentalOffers.Listings.Availability.Message\","
            ."  \"RentalOffers.Listings.Availability.MinOrderQuantity\","
            ."  \"RentalOffers.Listings.Availability.Type\","
            ."  \"RentalOffers.Listings.BasePrice\","
            ."  \"RentalOffers.Listings.Condition\","
            ."  \"RentalOffers.Listings.Condition.ConditionNote\","
            ."  \"RentalOffers.Listings.Condition.SubCondition\","
            ."  \"RentalOffers.Listings.DeliveryInfo.IsAmazonFulfilled\","
            ."  \"RentalOffers.Listings.DeliveryInfo.IsFreeShippingEligible\","
            ."  \"RentalOffers.Listings.DeliveryInfo.IsPrimeEligible\","
            ."  \"RentalOffers.Listings.DeliveryInfo.ShippingCharges\","
            ."  \"RentalOffers.Listings.MerchantInfo\","
            ."  \"SearchRefinements\""
            ." ],"
            ." \"SearchIndex\": \"All\","
            ." \"PartnerTag\": \"cookwarespa0a-20\","
            ." \"PartnerType\": \"Associates\","
            ." \"Marketplace\": \"www.amazon.com\""
            ."}";
        $host="webservices.amazon.com";
        $uriPath="/paapi5/searchitems";
        $awsv4 = new AwsV4 ($accessKey, $secretKey);
        $awsv4->setRegionName($region);
        $awsv4->setServiceName($serviceName);
        $awsv4->setPath ($uriPath);
        $awsv4->setPayload ($payload);
        $awsv4->setRequestMethod ("POST");
        $awsv4->addHeader ('content-encoding', 'amz-1.0');
        $awsv4->addHeader ('content-type', 'application/json; charset=utf-8');
        $awsv4->addHeader ('host', $host);
        $awsv4->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems');
        $headers = $awsv4->getHeaders ();
        $headerString = "";
        foreach ( $headers as $key => $value ) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }
        $params = array (
            'http' => array (
                'header' => $headerString,
                'method' => 'POST',
                'content' => $payload
            )
        );
        $stream = stream_context_create ( $params );

        $fp = @fopen ( 'https://'.$host.$uriPath, 'rb', false, $stream );
        $response = @stream_get_contents ( $fp );
        $response = json_decode($response,true);

        $searchResult = [];
        if (@$response['SearchResult']['Items']){
            foreach ($response['SearchResult']['Items'] as $result){
                $searchResult[] = [
                    'title' => $result['ItemInfo']['Title']['DisplayValue'],
                    'asin' => $result['ASIN'],
                    'image' => $result['Images']['Primary']['Medium']['URL'],
                    'url' => $result['DetailPageURL'],
                    'rating' => null,
                    'ratings_total' => null,
                    'price' => [
                        'value' => @$result['Offers']['Summaries'][0]['LowestPrice']['Amount'],
                        'symbol' => @$result['Offers']['Summaries'][0]['LowestPrice']['Currency'],
                        'raw' => @$result['Offers']['Summaries'][0]['LowestPrice']['DisplayAmount'],
                    ],
                    'categories' => null,
                ];
            }
        }

        $data = [
            'results' => @$searchResult,
            'related_searches' =>null,
            'related_brands' => null,
            'pagination' => null,
        ];

        return $data;
    }

    public function one()
    {
        $product = 'B088NBCD1H';
        $serviceName="ProductAdvertisingAPI";
        $region="us-east-1";
        $accessKey="AKIAI6BJD2TDO62RD4PA";
        $secretKey="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";
        $payload="{"
            ." \"ASIN\": \"$product\","
            ." \"Resources\": ["
            ."  \"BrowseNodeInfo.BrowseNodes\","
            ."  \"BrowseNodeInfo.BrowseNodes.Ancestor\","
            ."  \"BrowseNodeInfo.BrowseNodes.SalesRank\","
            ."  \"BrowseNodeInfo.WebsiteSalesRank\","
            ."  \"CustomerReviews.Count\","
            ."  \"CustomerReviews.StarRating\","
            ."  \"Images.Primary.Small\","
            ."  \"Images.Primary.Medium\","
            ."  \"Images.Primary.Large\","
            ."  \"Images.Primary.HighRes\","
            ."  \"Images.Variants.Small\","
            ."  \"Images.Variants.Medium\","
            ."  \"Images.Variants.Large\","
            ."  \"Images.Variants.HighRes\","
            ."  \"ItemInfo.ByLineInfo\","
            ."  \"ItemInfo.ContentInfo\","
            ."  \"ItemInfo.ContentRating\","
            ."  \"ItemInfo.Classifications\","
            ."  \"ItemInfo.ExternalIds\","
            ."  \"ItemInfo.Features\","
            ."  \"ItemInfo.ManufactureInfo\","
            ."  \"ItemInfo.ProductInfo\","
            ."  \"ItemInfo.TechnicalInfo\","
            ."  \"ItemInfo.Title\","
            ."  \"ItemInfo.TradeInInfo\","
            ."  \"Offers.Listings.Availability.MaxOrderQuantity\","
            ."  \"Offers.Listings.Availability.Message\","
            ."  \"Offers.Listings.Availability.MinOrderQuantity\","
            ."  \"Offers.Listings.Availability.Type\","
            ."  \"Offers.Listings.Condition\","
            ."  \"Offers.Listings.Condition.ConditionNote\","
            ."  \"Offers.Listings.Condition.SubCondition\","
            ."  \"Offers.Listings.DeliveryInfo.IsAmazonFulfilled\","
            ."  \"Offers.Listings.DeliveryInfo.IsFreeShippingEligible\","
            ."  \"Offers.Listings.DeliveryInfo.IsPrimeEligible\","
            ."  \"Offers.Listings.DeliveryInfo.ShippingCharges\","
            ."  \"Offers.Listings.IsBuyBoxWinner\","
            ."  \"Offers.Listings.LoyaltyPoints.Points\","
            ."  \"Offers.Listings.MerchantInfo\","
            ."  \"Offers.Listings.Price\","
            ."  \"Offers.Listings.ProgramEligibility.IsPrimeExclusive\","
            ."  \"Offers.Listings.ProgramEligibility.IsPrimePantry\","
            ."  \"Offers.Listings.Promotions\","
            ."  \"Offers.Listings.SavingBasis\","
            ."  \"Offers.Summaries.HighestPrice\","
            ."  \"Offers.Summaries.LowestPrice\","
            ."  \"Offers.Summaries.OfferCount\","
            ."  \"ParentASIN\","
            ."  \"RentalOffers.Listings.Availability.MaxOrderQuantity\","
            ."  \"RentalOffers.Listings.Availability.Message\","
            ."  \"RentalOffers.Listings.Availability.MinOrderQuantity\","
            ."  \"RentalOffers.Listings.Availability.Type\","
            ."  \"RentalOffers.Listings.BasePrice\","
            ."  \"RentalOffers.Listings.Condition\","
            ."  \"RentalOffers.Listings.Condition.ConditionNote\","
            ."  \"RentalOffers.Listings.Condition.SubCondition\","
            ."  \"RentalOffers.Listings.DeliveryInfo.IsAmazonFulfilled\","
            ."  \"RentalOffers.Listings.DeliveryInfo.IsFreeShippingEligible\","
            ."  \"RentalOffers.Listings.DeliveryInfo.IsPrimeEligible\","
            ."  \"RentalOffers.Listings.DeliveryInfo.ShippingCharges\","
            ."  \"RentalOffers.Listings.MerchantInfo\","
            ."  \"VariationSummary.Price.HighestPrice\","
            ."  \"VariationSummary.Price.LowestPrice\","
            ."  \"VariationSummary.VariationDimension\""
            ." ],"
            ." \"PartnerTag\": \"cookwarespa0a-20\","
            ." \"PartnerType\": \"Associates\","
            ." \"Marketplace\": \"www.amazon.com\""
            ."}";
        $host="webservices.amazon.com";
        $uriPath="/paapi5/getvariations";
        $awsv4 = new AwsV4 ($accessKey, $secretKey);
        $awsv4->setRegionName($region);
        $awsv4->setServiceName($serviceName);
        $awsv4->setPath ($uriPath);
        $awsv4->setPayload ($payload);
        $awsv4->setRequestMethod ("POST");
        $awsv4->addHeader ('content-encoding', 'amz-1.0');
        $awsv4->addHeader ('content-type', 'application/json; charset=utf-8');
        $awsv4->addHeader ('host', $host);
        $awsv4->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.GetVariations');
        $headers = $awsv4->getHeaders ();
        $headerString = "";
        foreach ( $headers as $key => $value ) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }
        $params = array (
            'http' => array (
                'header' => $headerString,
                'method' => 'POST',
                'content' => $payload
            )
        );
        $stream = stream_context_create ( $params );

        $fp = @fopen ( 'https://'.$host.$uriPath, 'rb', false, $stream );
        $response = @stream_get_contents ( $fp );

        $response = json_decode($response,true);

        return $response;

    }

}
