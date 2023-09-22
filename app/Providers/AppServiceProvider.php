<?php

namespace App\Providers;

use App\Interfaces\ProviderInterface;
use App\Models\Provider;
use App\Services\AmazonNativeService;
use App\Services\RainforestService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('paginate', function ($perPage = 10, $page = null, $total = null, $pageName = 'page') {

            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            $test = new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
            return $test;
//            return [
//                'current_page' => $test->currentPage(),
////                'data' => array_values($test->items()),
//                'data' => array_values($test->items()),
//                'total' => $test->total(),
//                'per_page' => $test->perPage(),
//                'previous_page_url' => $test->previousPageUrl(),
//                'next_page_url' => $test->nextPageUrl(),
//                'last_page' => $test->lastPage(),
//                'on_first_page' => $test->onFirstPage(),
//            ];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('providers')){
            $provider = DB::select(DB::raw('SELECT * FROM providers WHERE chance >= RAND() * 10 AND is_active = true ORDER BY chance ASC LIMIT 1'))[0];
            if (@!$provider){
                $provider = Provider::where('is_active',true)->first();
            }
            switch (@$provider->name){
                default:
                case 'amazon_native':
                    $this->app->bind(ProviderInterface::class,AmazonNativeService::class);
                    break;
                case 'rainforest':
                    $this->app->bind(ProviderInterface::class,RainforestService::class);
                    break;
            }
        }

    }
}
