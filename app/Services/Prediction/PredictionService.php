<?php

namespace App\Services\Prediction;

use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\StandingRepositoryInterface;
use Illuminate\Support\Collection;

class PredictionService implements PredictionServiceInterface
{
    protected StandingRepositoryInterface $standingRepository;
    protected FixtureRepositoryInterface $fixtureRepository;

    public function __construct(StandingRepositoryInterface $standingRepository, FixtureRepositoryInterface $fixtureRepository)
    {
        $this->standingRepository = $standingRepository;
        $this->fixtureRepository = $fixtureRepository;
    }

    /**
     * Championship prediction calculation
     *
     * @return array
     */
    public function make(): array
    {
        $finished = $this->standingRepository->getAll();
        if (!$this->checkIfPredictionIsNeeded()) {
            return [];
        }
        $teams = $this->collectionPredictions($finished);

        // get top team current point and number of fixture remained for each team
        $total_games = ($finished->count() - 1) * 2;

        $keys = array_keys($teams);
        $first_key = $keys[0];
        $remaining_points = 3 * ($total_games - $teams[$first_key]['played']);
        $top_team_point = $teams[$first_key]['points'];

        $raw_prediction = collect();
        foreach ($teams as $rank => $team) {
            $team['raw_prediction'] = $this->calculateTeamChance($team, $rank, $remaining_points, $top_team_point);
            $raw_prediction->add($team);
        }

        return $this->calculateChanceInPercentage($raw_prediction->sortByDesc('raw_prediction'));
    }

    /**
     * Team percentage calculation
     *
     * @param Collection $raw_prediction
     * @return array
     */
    public function calculateChanceInPercentage(Collection $raw_prediction): array
    {
        $one_point_percentage = $raw_prediction->sum('raw_prediction') > 0 ? 100 / $raw_prediction->sum('raw_prediction') : $raw_prediction->sum('raw_prediction');

        $raw_prediction->transform(function ($item) use ($one_point_percentage) {
            $item['percentage'] = round($item['raw_prediction'] * $one_point_percentage);
            return $item;
        });

        return $raw_prediction->toArray();
    }

    /**
     * Team chance calculation
     *
     * @param $team
     * @param $rank
     * @param $remained_points
     * @param $top_team_point
     * @return float
     */
    public function calculateTeamChance($team, $rank, $remained_points, $top_team_point): float
    {
        // check if team can be champions if win all future matches due to current top team
        if ($remained_points + $team['points'] < $top_team_point) {
            return 0;
        }
        $home_chance = 0;
        $away_chance = 0;

        $fixtures = $this->fixtureRepository->getAllMatchesByTeamId($team['team_id']);

        foreach ($fixtures as $fixture) {
            if ($fixture->home_team_id == $team['team_id']) {
                $home_chance += 2;
            }

            if ($fixture->away_team_id == $team['team_id']) {
                $away_chance += 1;
            }
        }

        $chance_by_remained_matches = ($home_chance + $away_chance);
        $chance_including_current_rank = $chance_by_remained_matches - ($rank / 2);
        $chance_including_points_difference = $chance_including_current_rank - (($top_team_point - $team['points']) / 2);
        return $chance_including_points_difference > 0 ? $chance_including_points_difference : 0;
    }

    /**
     * Collection by teams
     *
     * @param $data
     * @return array
     */
    private function collectionPredictions($data): array
    {
        $teams = [];
        $collection = collect($data);
        $collection->each(function ($item) use (&$teams) {
            $teams[$item->team_id]['points'] = $item->points;
            $teams[$item->team_id]['played'] = $item->played;
            $teams[$item->team_id]['team_id'] = $item->team_id;
            $teams[$item->team_id]['team_name'] = $item->name;
        });
        return $teams;
    }

    /**
     * Check if prediction available in this week
     *
     * @return bool
     */
    public function checkIfPredictionIsNeeded(): bool
    {
        $first = $this->standingRepository->checkStandingStatus();
        if (is_null($first) || $first->played < 3 || $first->played == 6) {
            return false;
        }
        return true;
    }
}
