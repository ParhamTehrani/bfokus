<?php

namespace App\Http\Controllers;

use App\Interfaces\ProviderInterface;
use App\Services\AmazonNativeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

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

        Session::put('last_list', json_encode($products));
        Session::put('last_search', $search);
        return view("list",compact('products','maxPrice','minPrice','minStar','search'));
    }

    public function one(ProviderInterface $provider,$asin)
    {
        $product_list = Session::get('last_list');
        $product_list = json_decode($product_list,true);
        $product = $provider->one($asin);
        if (!$product){
            return redirect('/result/' . Session::get('last_search'));
        }
        $index = null;
        foreach ($product_list as $key => $pr){
            if ($pr['asin'] == @$asin){
                $index = $key;
            }
        }
        if (\request()->has('next')){
            $newProduct = @$product_list[$index+1];
            if (@$newProduct){
                return redirect('/product/' . $newProduct['asin']);
            }else{
                $newProduct = end($product_list);
                return redirect('/product/' . $newProduct['asin']);
            }
        }
        if (\request()->has('previous')){
            $newProduct = @$product_list[$index-1];
            if (@$newProduct){
                return redirect('/product/' . $newProduct['asin']);
            }else{
                $newProduct = $product_list[1];
                return redirect('/product/' . $newProduct['asin']);
            }
        }
        return view('single-product',compact('product','index','product_list'));
    }
}
