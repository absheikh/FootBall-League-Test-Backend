<?php

namespace App\Http\Controllers;
use App\Models\Fixture;
use App\Models\Player;
use App\Models\Result;
use App\Models\Standing;


class HomePageController extends Controller
{
    //upcoming fixtures (3) using date_time
    public function upcomingFixtures(){
        try{
            //upcoming fixtures with home team and away team
            $upcomingFixtures = Fixture::with('homeTeam', 'awayTeam')->where('date_time', '>', now())->limit(3)->get();
            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>$upcomingFixtures
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    //new players (4) using created_at
    public function newPlayers(){
        try{
            $newPlayers = Player::orderBy('created_at', 'desc')->limit(4)->get();
            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>$newPlayers
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    //lates result (1) using created_at
    public function latestResult(){
        try{
            //with match, home team and away team
            $latestResult = Result::with('match', 'match.homeTeam', 'match.awayTeam')->orderBy('created_at', 'desc')->first();
            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>$latestResult
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    //standings (10)
    public function standings(){
        try{
            $standings = Standing::with("team")->orderBy('points', 'desc')->limit(10)->get();
            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>$standings
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }



}
