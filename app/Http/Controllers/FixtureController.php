<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fixture;

class FixtureController extends Controller
{
    public function getFixtures(){
        try{
            $fixtures = Fixture::with('homeTeam', 'awayTeam')->get();

            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>$fixtures
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    public function getFixture($id){
        try{
            $fixture = Fixture::find($id);
            if($fixture){
                return response()->json([
                    'status'=>true,
                    'message'=>'Fetched',
                    'data'=>$fixture
                ], 200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Fixture not found'
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    public function createFixture(Request $request){
        try{

            if(!$request->home_team_id || !$request->away_team_id || !$request->date_time || !$request->location || !$request->fixture_name){
                return response()->json([
                    'status'=>false,
                    'message'=>'All fields are required'
                ], 400);
            }

            //home team and away team should not be the same
            if($request->home_team_id == $request->away_team_id){
                return response()->json([
                    'status'=>false,
                    'message'=>'Home team and away team should not be the same'
                ], 400);
            }
          
           

            $fixture = new Fixture();
            $fixture->home_team_id = $request->home_team_id;
            $fixture->away_team_id = $request->away_team_id;
            $fixture->date_time = $request->date_time;
            $fixture->location = $request->location;
            $fixture->fixture_name = $request->fixture_name;
            $fixture->save();

            return response()->json([
                'status'=>true,
                'message'=>'Fixture created',
                'data'=>$fixture
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    public function updateFixture(Request $request, $id){
        try{
            if(!$request->home_team_id || !$request->away_team_id || !$request->date_time || !$request->location || !$request->fixture_name){
                return response()->json([
                    'status'=>false,
                    'message'=>'All fields are required'
                ], 400);
            }

             //home team and away team should not be the same
            if($request->home_team_id == $request->away_team_id){
                return response()->json([
                    'status'=>false,
                    'message'=>'Home team and away team should not be the same'
                ], 400);
            }

            $fixture = Fixture::find($id);
            if($fixture){
                $fixture->home_team_id = $request->home_team_id;
                $fixture->away_team_id = $request->away_team_id;
                $fixture->date_time = $request->date_time;
                $fixture->location = $request->location;
                $fixture->fixture_name = $request->fixture_name;
                $fixture->save();

                return response()->json([
                    'status'=>true,
                    'message'=>'Fixture updated',
                    'data'=>$fixture
                ], 200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Fixture not found'
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    public function deleteFixture($id){
        try{
          
            $fixture = Fixture::find($id);
            if($fixture){
                $fixture->delete();
                return response()->json([
                    'status'=>true,
                    'message'=>'Fixture deleted'
                ], 200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Fixture not found'
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }
    
}
