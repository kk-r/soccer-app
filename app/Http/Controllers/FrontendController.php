<?php

namespace App\Http\Controllers;

use App\Repositories\TeamRepository;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;

    }
    public function index()
    {
        return view('welcome');
    }

    public function getPlayers($id)
    {
        return view('team')->withId($id);
    }
}
