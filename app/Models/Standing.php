<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $fillable = [
        'team_id',
        'played',
        'won',
        'drawn',
        'lost',
        'points',
        'goals_for',
        'goals_against',
        'goal_difference',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
