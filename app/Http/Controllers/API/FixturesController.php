<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Resources\FixtureResource;
use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\StandingRepositoryInterface;
use App\Services\Fixture\FixtureServiceInterface;
use Illuminate\Http\JsonResponse;
use RuntimeException;
use Throwable;

class FixturesController extends ApiController
{
    private FixtureServiceInterface $fixtureService;
    private FixtureRepositoryInterface $fixtureRepository;
    private StandingRepositoryInterface $standingRepository;

    public function __construct(FixtureServiceInterface $fixtureService, FixtureRepositoryInterface $fixtureRepository, StandingRepositoryInterface $standingRepository)
    {
        $this->fixtureService = $fixtureService;
        $this->fixtureRepository = $fixtureRepository;
        $this->standingRepository = $standingRepository;
    }

    public function generateAll(): JsonResponse
    {
        if ($this->fixtureRepository->checkIfFixturesDrawn()) {
            return $this->sendError('Already generated', [], 400);
        }

        try {
            $team_ids = $this->standingRepository->getTeams()->toArray();
            $this->fixtureService->generate($team_ids);
            $fixtures = $this->fixtureRepository->getFixtures();
            return $this->sendResponse('OK', FixtureResource::collection($fixtures));
        } catch (RuntimeException $exception) {
            return $this->sendError($exception->getMessage(), [], 400);
        } catch (Throwable $exception) {
            return $this->sendError($exception->getMessage(), [], 500);
        }
    }

    public function playAll(): JsonResponse
    {
        if (!$this->fixtureRepository->checkIfFixturesDrawn()) {
            return $this->sendError('Failed', [], 400);
        }

        try {
            $this->fixtureService->playAll();
            return $this->sendResponse('OK');
        } catch (RuntimeException $exception) {
            return $this->sendError($exception->getMessage(), [], 400);
        } catch (Throwable $exception) {
            return $this->sendError($exception->getMessage(), [], 500);
        }
    }

    public function nextWeek(): JsonResponse
    {
        if (!$this->fixtureRepository->checkIfFixturesDrawn()) {
            return $this->sendError('Failed', [], 400);
        }

        try {
            $this->fixtureService->playWeek();
            return $this->sendResponse('OK');
        } catch (RuntimeException $exception) {
            return $this->sendError($exception->getMessage(), [], 400);
        } catch (Throwable $exception) {
            return $this->sendError($exception->getMessage(), [], 500);
        }
    }
}
