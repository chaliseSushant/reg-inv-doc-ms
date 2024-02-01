<?php

namespace App\Providers;

use App\Helpers\LogActivity;
use App\Repository\ActivityRepository;
use App\Repository\Interfaces\ActivityRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class ActivityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LogActivity::class , function (){
            $request = app(Request::class);
            $activityRepository = app(ActivityRepository::class);
            return new LogActivity($request,$activityRepository);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
