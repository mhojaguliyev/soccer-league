<?php

namespace Tests\Unit;

use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\StandingRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StandingTest extends TestCase
{
    use RefreshDatabase;

    protected FixtureRepositoryInterface $fixtureRepo;
    protected StandingRepositoryInterface $standingRepo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixtureRepo = $this->app->make(FixtureRepositoryInterface::class);
        $this->standingRepo = $this->app->make(StandingRepositoryInterface::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_standing_create()
    {
        $this->standingRepo->createStanding();
        $teams_count = $this->standingRepo->getTeams()->count();
        $standing_count = $this->standingRepo->getAll()->count();
        $this->assertEquals($teams_count, $standing_count);
    }

    public function test_fixture_truncate()
    {
        $this->fixtureRepo->truncateFixtures();
        $is_drawn = $this->fixtureRepo->checkIfFixturesDrawn();
        $this->assertNotTrue($is_drawn);
    }
}
