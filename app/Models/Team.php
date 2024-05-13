<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['team_name', 'city', 'logo_url'];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(Fixture::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(Fixture::class, 'away_team_id');
    }
}
