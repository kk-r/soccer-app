<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable  = [
        'first_name',
        'last_name',
        'logo_url',
        'team_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
