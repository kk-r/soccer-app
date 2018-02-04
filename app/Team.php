<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $fillable = [
        'name',
        'logo_url',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function delete()
    {
        if ($this->players) {
            $this->players->each(function($player) {
                $player->team_id = null;
                $player->save();
            });
        }

        return parent::delete();
    }
}
