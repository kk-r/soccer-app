<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends BaseController
{

    public function show()
    {
        return redirect()->route('admin_teams');
    }

    public function teams()
    {
        return view('admin')->withTeams(true);
    }
    public function players()
    {
        return view('admin')->withPlayers(true);
    }
}
