<?php

namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\Fixture;
use App\Models\Result;
use App\Models\Standing;
use App\Models\Player;

class DashboardStatsController extends Controller
{
    //Get stats
    public function stats(){
        try{
             $totalTeams = Team::count();
             $totalFixtures = Fixture::count();
             $totalResults = Result::count();
             $totalStandings = Standing::count();
             $totalPlayers = Player::count();
             $totalTeams = Team::count();
            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>[
                    'totalTeams'=>$totalTeams,
                    'totalFixtures'=>$totalFixtures,
                    'totalResults'=>$totalResults,
                    'totalStandings'=>$totalStandings,
                    'totalPlayers'=>$totalPlayers
                ]
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

   
    
}
