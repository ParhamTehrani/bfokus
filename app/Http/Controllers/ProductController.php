<?php

namespace App\Http\Controllers;

use App\Interfaces\ProviderInterface;
use App\Services\AmazonNativeService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view("index");
    }

    public function search($search)
    {
        return view("search-confirm",compact('search'));

    }
    public function search2(ProviderInterface $provider,$search)
    {
        $result = $provider->search($search);
        $products = $result['results'];
        $maxPrice = max(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
        $minPrice = min(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
        $minStar  = min(count(array_filter(array_column($products,'rating'))) > 0 ? array_filter(array_column($products,'rating')) : [0]);
        return view("list",compact('products','maxPrice','minPrice','minStar','search'));
    }
}
