@extends('layouts.app')

@section('menu')
    <li class="{{ \Request::route()->getName()==='admin_teams' ? 'active' : '' }}"><a href="{{ route('admin_teams') }}">Teams</a></li>
    <li class="{{\Request::route()->getName()==='admin_players' ? 'active' : '' }}"><a href="{{ route('admin_players') }}">Players</a></li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @auth
                @if(isset($players))
                    <player-curd></player-curd>
                @elseif(isset($teams))
                    <team-curd></team-curd>
                @endif
            @endauth
        </div>
    </div>
@endsection
