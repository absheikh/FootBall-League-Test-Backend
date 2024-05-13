<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['player_name', 'position', 'nationality', 'jersey_number', 'team_id', 'image_url'];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
