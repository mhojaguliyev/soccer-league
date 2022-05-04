<?php

namespace App\Providers;

use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\StandingRepositoryInterface;
use App\Repository\FixtureRepository;
use App\Repository\StandingRepository;
use App\Services\Fixture\FixtureService;
use App\Services\Fixture\FixtureServiceInterface;
use App\Services\Prediction\PredictionService;
use App\Services\Prediction\PredictionServiceInterface;
use App\Services\Simulator\MatchSimulator;
use App\Services\Simulator\MatchSimulatorInterface;
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
        // repositories
        $this->app->bind(FixtureRepositoryInterface::class, FixtureRepository::class);
        $this->app->bind(StandingRepositoryInterface::class, StandingRepository::class);

        // services
        $this->app->bind(FixtureServiceInterface::class, FixtureService::class);
        $this->app->bind(MatchSimulatorInterface::class, MatchSimulator::class);
        $this->app->bind(PredictionServiceInterface::class, PredictionService::class);
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
