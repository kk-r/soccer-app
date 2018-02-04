<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Repositories\PlayerRepository;

class PlayerController extends BaseController
{
    protected $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = $this->playerRepository->getAll()->toArray();

        return $this
            ->setStatusCode(200)
            ->setDataBag($players)
            ->respond(true, 'All players information.');
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerRequest $request)
    {
        $this->playerRepository->store($request->only(['first_name', 'last_name', 'logo_url', 'team_id']));

        return $this
            ->setStatusCode(200)
            ->setDataBag([])
            ->respond(true, 'Player created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $player = $this->playerRepository->find($id);
        return $this
            ->setStatusCode(200)
            ->setDataBag($player)
            ->respond(true, 'Player information.');
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
    public function update(PlayerRequest $request, $id)
    {
        $this->playerRepository->update($id, $request->only(['id', 'first_name', 'last_name', 'logo', 'team_id']));
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
        $this->playerRepository->delete($id);
        return $this
            ->setStatusCode(200)
            ->setDataBag([])
            ->respond(true, 'Deleted Successfully');

    }
}
