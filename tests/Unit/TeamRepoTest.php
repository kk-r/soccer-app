<?php

namespace Tests\Unit;

use App\Player;
use App\Repositories\TeamRepository;
use App\Team;
use Tests\TestCase;

class TeamRepoTest extends TestCase
{

    protected $teamRepository;

    public function __construct()
    {
        parent::__construct();
        $this->teamRepository = new TeamRepository(new Team());
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAll()
    {

        $teams = $this->teamRepository->getAll();

        $this->assertTrue($teams->isNotEmpty());
    }

    public function testCreate()
    {
        $team = factory(\App\Team::class)->make()->toArray();

        $teams = $this->teamRepository->store($team);

        $this->assertDatabaseHas('teams', $teams->toArray());
    }


    public function testFind()
    {
        $team = factory(\App\Team::class)->make()->toArray();

        $team = $this->teamRepository->store($team);

        $foundedTeam = $this->teamRepository->find($team->id);

        $this->assertDatabaseHas('teams', $foundedTeam);
        try {
            $nonFoundedTeam = $this->teamRepository->find($team->id + 1);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }

    }

    public function testUpdate()
    {
        $team1 = factory(\App\Team::class)->make()->toArray();

        $createdTeam = $this->teamRepository->store($team1);

        $team2 = factory(\App\Team::class)->make()->toArray();

        $this->teamRepository->update($createdTeam->id, $team2);

        $this->assertDatabaseHas('teams', $team2);

    }

    public function testDelete()
    {
        $team = factory(\App\Team::class)->make()->toArray();

        $teams = $this->teamRepository->store($team);

        $foundedTeam = $this->teamRepository->delete($teams->id);

        $this->assertTrue($foundedTeam);

        try {
            $nonFoundedTeam = $this->teamRepository->delete($teams->id);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }

    }
}
