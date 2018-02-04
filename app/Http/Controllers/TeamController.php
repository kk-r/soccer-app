<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;

class TeamController extends BaseController
{

    protected $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = $this->teamRepository->getAll()->toArray();
        return $this
            ->setStatusCode(200)
            ->setDataBag($teams)
            ->respond(true, 'All teams information.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TeamRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {

        $this->teamRepository->store($request->only(['name', 'logo_url']));

        return $this
            ->setStatusCode(200)
            ->setDataBag([])
            ->respond(true, 'Team created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = $this->teamRepository->find($id);
        return $this
            ->setStatusCode(200)
            ->setDataBag($team)
            ->respond(true, 'Team information.');
    }


    public function getPlayer($id)
    {
        $players = $this->teamRepository->getPlayer($id);

        return $this
            ->setStatusCode(200)
            ->setDataBag($players)
            ->respond(true, 'Team Players Details');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, $id)
    {
        $this->teamRepository->update($id, $request->only(['name', 'logo_url']));
        return $this
            ->setStatusCode(200)
            ->setDataBag([])
            ->respond(true, 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->teamRepository->delete($id);
        return $this
            ->setStatusCode(200)
            ->setDataBag([])
            ->respond(true, 'Deleted Successfully');

    }
}
