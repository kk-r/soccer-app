<?php

namespace App\Repositories;

use App\Exceptions\AppException;
use App\Team;

/**
 * Class TeamRepository
 * @package App\Repositories
 */
class TeamRepository extends AbstractRepository
{
    public function __construct(Team $team)
    {
        $this->setBaseModel($team);
        $this->setNotDeletedExceptionMessage("Team not deleted.");
        $this->setNotFoundExceptionMessage("Team not found.");
        $this->setNotSavedExceptionMessage("Team not saved.");
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getPlayer($id)
    {
        try {
            $team = Team::with('players')->findOrfail($id);
        } catch (\Exception $e) {
            throw new AppException("Team not found", $e->getMessage(), $e->getCode());
        }
        return $team->players->toArray();
    }
}
