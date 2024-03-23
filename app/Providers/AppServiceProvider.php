<?php

namespace App\Providers;

use App\Repository\DailyRecordRepository;
use App\Repository\IDailyRecordRepository;
use App\Repository\IUserRepository;
use App\Repository\UserRepository;
use App\Service\DailyRecordService;
use App\Service\IDailyRecordService;
use App\Service\IUserService;
use App\Service\UserService;
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
        $this->app->bind(UserRepository::class, IUserRepository::class);
        $this->app->bind(UserService::class, IUserService::class);
        $this->app->bind(DailyRecordRepository::class, IDailyRecordRepository::class);
        $this->app->bind(DailyRecordService::class, IDailyRecordService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
