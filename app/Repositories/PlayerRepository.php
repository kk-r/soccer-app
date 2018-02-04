<?php

namespace App\Repositories;

use App\Player;

class PlayerRepository extends AbstractRepository
{
    public function __construct(Player $player)
    {
        $this->setBaseModel($player);
        $this->setNotDeletedExceptionMessage("Player not deleted.");
        $this->setNotFoundExceptionMessage("Player not found.");
        $this->setNotSavedExceptionMessage("Player not saved.");
    }
}
