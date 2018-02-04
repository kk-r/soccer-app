<?php
namespace App\Repositories;

use App\Exceptions\AppException;
use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuickAddMigrationManager
 */
abstract class AbstractRepository
{
    protected $notFoundExceptionMessage = '';
    protected $notDeletedExceptionMessage = '';
    protected $notSavedExceptionMessage = '';
    protected $baseModel;

    public function __construct()
    {

    }

    public function setBaseModel(Model $model)
    {
        $this->baseModel = $model;
    }

    public function setNotFoundExceptionMessage($message = '')
    {
        $this->notFoundExceptionMessage = $message;
    }

    public function setNotDeletedExceptionMessage($message)
    {
        $this->notDeletedExceptionMessage = $message;
    }

    public function setNotSavedExceptionMessage($message)
    {
        $this->notSavedExceptionMessage = $message;
    }

    public function getNotFoundExceptionMessage()
    {
        return $this->notFoundExceptionMessage;
    }

    public function getNotDeletedExceptionMessage()
    {
        return $this->notDeletedExceptionMessage;
    }

    public function getNotSavedExceptionMessage()
    {
        return $this->notSavedExceptionMessage;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->baseModel::get();
    }

    /**
     * @param $team
     * @return mixed
     */
    public function store($data)
    {
        try {
            \DB::beginTransaction();
            $player = $this->baseModel::create($data);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new AppException($this->getNotSavedExceptionMessage(), $e->getMessage(), $e->getCode());
        }
        return $player;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        try {
            $player = $this->baseModel::findOrfail($id)->toArray();
        } catch (\Exception $e) {
            throw new AppException($this->getNotFoundExceptionMessage(), $e->getMessage(), $e->getCode());
        }
        return $player;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        try {
            \DB::beginTransaction();
            $player = $this->baseModel::findOrfail($id);
            $player->update($data);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new AppException($this->getNotFoundExceptionMessage(), $e->getMessage(), $e->getCode());
        }
        return $player;
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        try {
            \DB::beginTransaction();
            $player = $this->baseModel::findOrfail($id);
            $player->delete();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new AppException($this->getNotDeletedExceptionMessage(), $e->getMessage(), $e->getCode());
        }
        return true;
    }
}
