<?php

namespace App\Repository;

use App\Interfaces\FixtureRepositoryInterface;
use App\Models\Fixture;
use Illuminate\Support\Collection;
use stdClass;

class FixtureRepository implements FixtureRepositoryInterface
{
    private Fixture $fixture;

    public function __construct(Fixture $fixture)
    {
        $this->fixture = $fixture;
    }

    /**
     * Checks if fixtures are generated
     *
     * @return bool
     */
    public function checkIfFixturesDrawn(): bool
    {
        return $this->fixture->count() > 0;
    }

    /**
     * Reset fixture data
     */
    public function truncateFixtures(): void
    {
        $this->fixture->truncate();
    }

    /**
     * Get current week fixtures
     *
     * @return stdClass|null
     */
    public function currentWeek(): ?stdClass
    {
        if (!$this->checkIfFixturesDrawn()) {
            return null;
        }

        $week_num = $this->fixture->notPlayed()->min('week_number');

        if (!$week_num) {
            $week_num = $this->fixture->max('week_number');
        }

        $by_week = $this->transformByWeek($this->getFixtureByWeekId($week_num));
        return $by_week->first();
    }

    /**
     * Get all fixtures grouped by weeks
     *
     * @return Collection
     */
    public function getFixtures(): Collection
    {
        $fixtures = $this->fixture->ordered()->with(['homeTeam', 'awayTeam'])->get();
        return $this->transformByWeek($fixtures);
    }

    /**
     * Get fixtures by week
     *
     * @param $week_num
     * @return Collection
     */
    public function getFixtureByWeekId($week_num): Collection
    {
        return $this->fixture->with(['homeTeam', 'awayTeam'])
            ->where('week_number', $week_num)
            ->get();
    }

    /**
     * Get not played fixtures of team
     *
     * @param $teamId
     * @return Collection
     */
    public function getAllMatchesByTeamId($teamId): Collection
    {
        return $this->fixture
            ->where(function ($q) use ($teamId) {
                $q->where('home_team_id', '=', $teamId)
                    ->orWhere('away_team_id', '=', $teamId);
            })
            ->where('status', false)
            ->get();
    }

    /**
     * Transform fixture collection by week numbers
     *
     * @param Collection $fixtures
     * @return Collection
     */
    private function transformByWeek(Collection $fixtures): Collection
    {
        $result = [];
        foreach ($fixtures->groupBy('week_number') as $week_number => $collection) {
            $week_object = new stdClass();
            $week_object->number = $week_number;
            $week_object->matches = $collection;
            $result[] = $week_object;
        }

        return collect($result);
    }
}
