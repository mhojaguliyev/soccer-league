<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Resources\FixtureResource;
use App\Http\Resources\PredictionResource;
use App\Http\Resources\StandingsResource;
use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\StandingRepositoryInterface;
use App\Services\Prediction\PredictionServiceInterface;
use Illuminate\Http\JsonResponse;

class TeamsController extends ApiController
{
    private StandingRepositoryInterface $standingRepository;
    private FixtureRepositoryInterface $fixtureRepository;
    private PredictionServiceInterface $predictionService;

    public function __construct(StandingRepositoryInterface $standingRepository, FixtureRepositoryInterface $fixtureRepository, PredictionServiceInterface $predictionService)
    {
        $this->standingRepository = $standingRepository;
        $this->fixtureRepository = $fixtureRepository;
        $this->predictionService = $predictionService;
    }

    public function index(): JsonResponse
    {
        $teams = $this->standingRepository->getAll();
        $currentWeek = $this->fixtureRepository->currentWeek();

        return $this->sendResponse('OK', [
            'table' => StandingsResource::collection($teams),
            'nextWeekFixtures' => !is_null($currentWeek) ? new FixtureResource($currentWeek) : null,
        ]);
    }

    public function reset(): JsonResponse
    {
        $this->fixtureRepository->truncateFixtures();
        $this->standingRepository->truncateStanding();
        $this->standingRepository->createStanding();

        return $this->sendResponse('Cleared.');
    }

    public function fixtures(): JsonResponse
    {
        return $this->sendResponse('OK', FixtureResource::collection($this->fixtureRepository->getFixtures()));
    }

    public function predictions(): JsonResponse
    {
        $prediction_status = $this->predictionService->make();
        return $this->sendResponse('OK', PredictionResource::collection($prediction_status));
    }
}
