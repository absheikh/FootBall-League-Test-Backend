<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $fillable = ['fixture_name','home_team_id', 'away_team_id', 'date_time', 'location'];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
