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
        Session::put('user_lang',\request()->lang);
        return view("search-confirm",compact('search'));
    }
    public function search2(ProviderInterface $provider,$search)
    {
        $products = Session::get('provider_'. $provider->getProvider() . ': ' .$search);
        $index = null;
        if (@count(@$products ?? [])){
            if (\request()->has('index')){
                $index = \request()->get('index');
            }
            $maxPrice = max(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minPrice = min(count(array_filter(array_column($products,'price'))) > 0 ? array_column(array_filter(array_column($products,'price')),'value') : [0]);
            $minStar  = min(count(array_filter(array_column($products,'rating'))) > 0 ? array_filter(array_column($products,'rating')) : [0]);
            $hasMore = count($products) > 7;
            $products = array_slice($products,0,7);
            $symbol = @$products[0]['price']['symbol'];
            return view("list",compact('products','maxPrice','minPrice','minStar','search','index','hasMore','symbol'));

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
                Session::put('provider_'. $provider->getProvider() . ': ' .$search,$products,60 * 60 * 1);
            }
            $hasMore = count($products) > 7;
            $products = array_slice($products,0,7);
            $symbol = @$products[0]['price']['symbol'];
            return view("list",compact('products','maxPrice','minPrice','minStar','search','index','hasMore','symbol'));
        }
    }


    public function search_page(Request $request,$search,ProviderInterface $provider)
    {
        $products = Session::get('provider_'. $provider->getProvider() . ': ' .$search);
        if ($search){
            if ($request->page){
                $productsCount = @count($products);
                $products = @array_slice($products,0 + (7 *( $request->page - 1)),7);
                return response()->json([
                    'products' => $products,
                    'more_page' => $productsCount > 6 + (7 *( $request->page - 1))
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
        $providerName = $provider->getProvider();
        $product = $provider->one($asin);
        if (!$product){
            return redirect('/result/' . Session::get('last_search_' . $provider->getProvider()));
        }
        $index = null;
        if($product_list){
            foreach ($product_list as $key => $pr){
                if ($pr['asin'] == @$asin){
                    $index = $key + 1;
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
        }


        return view('single-product',compact('product','index','product_list','providerName'));
    }

    public function terms()
    {
        return view('terms');
    }

    public function policy()
    {
        return view('policy');
    }

    public function acceptTerms()
    {
        $cookie = cookie('terms', 'accept', 24 * 60 * 60);
        return response('done')->cookie($cookie);
    }
}
