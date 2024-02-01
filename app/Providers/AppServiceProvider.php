<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        JsonResource::withoutWrapping();

        Validator::extend('max_uploaded_file_size', function ($attribute, $value, $parameters, $validator) {

            $total_size = array_reduce($value, function ( $sum, $item ) {
                // each item is UploadedFile Object
                $sum += filesize($item->path());
                return $sum;
            });

            // $parameters[0] in kilobytes
            return $total_size < $parameters[0] * 1024;

        });



        //Paginator::useBootstrap();
        // Enable pagination
        /*if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate',
                function ($perPage = 15, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage)->values()->all(), $this->count(), $perPage, $page, $options))
                        ->withPath('');
                });
        }*/
    }
}
