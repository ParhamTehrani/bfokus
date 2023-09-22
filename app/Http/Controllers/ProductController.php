<?php

namespace App\Http\Controllers;

use App\Interfaces\ProviderInterface;
use App\Services\AmazonNativeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $products = Cache::get($search);
        if ($products){
            if (\request()->has('index')){
                $index = \request()->get('index');
            }
            $products = json_decode($products,true);
            dd($products);
            $maxPrice = max(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minPrice = min(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minStar  = min(count(array_filter(array_column($products,'rating'))) > 0 ? array_filter(array_column($products,'rating')) : [0]);
            $products = array_slice($products,0,6);
            return view("list",compact('products','maxPrice','minPrice','minStar','search','index'));

        }else{
            $last_search = Session::get('last_search');
            if ($last_search == $search){
                $products = Session::get('last_list');
                $products = json_decode($products,true);
            }else{
                $result = $provider->search($search);
                $products = $result['results'];
            }
            $maxPrice = max(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minPrice = min(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minStar  = min(count(array_filter(array_column($products,'rating'))) > 0 ? array_filter(array_column($products,'rating')) : [0]);

            Session::put('last_list', json_encode($products));
            Session::put('last_search', $search);
            $index = null;


            if (\request()->has('index')){
                $index = \request()->get('index');
            }
            Cache::put($search,json_encode($products),60 * 60 * 1);
            $products = array_slice($products,0,6);
            return view("list",compact('products','maxPrice','minPrice','minStar','search','index'));
        }
    }


    public function search_page(Request $request,$search)
    {
        $products = Cache::get($search);
        if ($search){
            if ($request->page){
                $products = json_decode($products,true);
                $productsCount = @count($products);
                $products = @array_slice($products,0 + (7 * $request->page),6 + (7 * $request->page));
                return response()->json([
                    'products' => $products,
                    'more_page' => $productsCount > 6 + (7 * $request->page)
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => 'page parameter is required'
                ],400);
            }
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'something went wrong'
            ],400);
        }
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
