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
        $products = Cache::get('provider_'. $provider->getProvider() . ': ' .$search);
        $index = null;

        if (@count(@$products ?? [])){
            if (\request()->has('index')){
                $index = \request()->get('index');
            }
            $products = $products;
            $maxPrice = max(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minPrice = min(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minStar  = min(count(array_filter(array_column($products,'rating'))) > 0 ? array_filter(array_column($products,'rating')) : [0]);
            $products = array_slice($products,0,7);
            return view("list",compact('products','maxPrice','minPrice','minStar','search','index'));

        }else{
            $last_search = Session::get('last_search_' . $provider->getProvider());
            if ($last_search == $search){
                $products = Session::get('last_list_' . $provider->getProvider());
            }else{
                $result = $provider->search($search);
                $products = $result['results'];
            }
            $maxPrice = max(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minPrice = min(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minStar  = min(count(array_filter(array_column($products,'rating'))) > 0 ? array_filter(array_column($products,'rating')) : [0]);

            Session::put('last_list_' . $provider->getProvider(), $products);
            Session::put('last_search_' . $provider->getProvider(), $search);


            if (\request()->has('index')){
                $index = \request()->get('index');
            }
            if (count($products)){
                Cache::put('provider_'. $provider->getProvider() . ': ' .$search,$products,60 * 60 * 1);
            }
            $products = array_slice($products,0,7);

            return view("list",compact('products','maxPrice','minPrice','minStar','search','index'));
        }
    }


    public function search_page(Request $request,$search,ProviderInterface $provider)
    {
        $products = Cache::get('provider_'. $provider->getProvider() . ': ' .$search);
        if ($search){
            if ($request->page){
                $productsCount = @count($products);
                $products = @array_slice($products,0 + (7 * $request->page),7);
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
        $product_list = Session::get('last_list_' . $provider->getProvider());
        $product_list = $product_list;
        $product = $provider->one($asin);
        if (!$product){
            return redirect('/result/' . Session::get('last_search_' . $provider->getProvider()));
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
