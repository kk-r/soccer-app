<?php

namespace Tests\Feature;

use App\Player;
use App\Repositories\PlayerRepository;
use Tests\TestCase;

class PlayerRepoTest extends TestCase
{
    protected $playerRepository;

    public function __construct()
    {
        parent::__construct();
        $this->playerRepository = new PlayerRepository(new Player());
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAll()
    {

        $players = $this->playerRepository->getAll();

        $this->assertTrue($players->isNotEmpty());
    }

    public function testCreate()
    {
        $player = factory(\App\Player::class)->make()->toArray();

        $players = $this->playerRepository->store($player);

        $this->assertDatabaseHas('players', $players->toArray());
    }


    public function testFind()
    {
        $player = factory(\App\Player::class)->make()->toArray();

        $player = $this->playerRepository->store($player);

        $foundedPlayer = $this->playerRepository->find($player->id);

        $this->assertDatabaseHas('players', $foundedPlayer);

        try {
            $this->playerRepository->find($player->id + 1);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }

    }

    public function testUpdate()
    {
        $player1 = factory(\App\Player::class)->make()->toArray();

        $createdPlayer = $this->playerRepository->store($player1);

        $player2 = factory(\App\Player::class)->make()->toArray();

        $this->playerRepository->update($createdPlayer->id, $player2);

        $this->assertDatabaseHas('players', $player2);

    }

    public function testDelete()
    {
        $player = factory(\App\Player::class)->make()->toArray();

        $player = $this->playerRepository->store($player);

        $deletedPlayer = $this->playerRepository->delete($player->id);

        $this->assertTrue($deletedPlayer);

        try {
            $nonFoundedPlayer = $this->playerRepository->delete($player->id);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }

    }
}
