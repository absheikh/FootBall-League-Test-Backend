<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Fixture;
class ResultController extends Controller
{
    public function getResults(){
        try{
            
            $results = Result::with('match','match.homeTeam', 'match.awayTeam')->get();

            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>$results
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    public function getResult($id){
        try{
            //result with match
            $result = Result::with('match')->find($id);
            if($result){
                return response()->json([
                    'status'=>true,
                    'message'=>'Fetched',
                    'data'=>$result
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Result not found'
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    public function createResult(Request $request){
        try{

            if(!$request->home_team_score || !$request->away_team_score || !$request->match_id){
                return response()->json([
                    'status'=>false,
                    'message'=>'All fields are required'
                ], 400);
            }

            if(!is_numeric($request->home_team_score) || !is_numeric($request->away_team_score)){
                return response()->json([
                    'status'=>false,
                    'message'=>'Scores must be numbers'
                ], 400);
            }

            //check if match exists
            $match = Fixture::find($request->match_id);
            if(!$match){
                return response()->json([
                    'status'=>false,
                    'message'=>'Match not found'
                ], 404);
            }

           

            $result = new Result();
            $result->home_team_score = $request->home_team_score;
            $result->away_team_score = $request->away_team_score;
            $result->match_id = $request->match_id;
            $result->save();

            return response()->json([
                'status'=>true,
                'message'=>'Result created',
                'data'=>$result
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error '.$e->getMessage()
            ], 500);
        }
    }

    public function updateResult(Request $request, $id){
        try{
            if(!$request->home_team_score || !$request->away_team_score || !$request->match_id){
                return response()->json([
                    'status'=>false,
                    'message'=>'All fields are required'
                ], 400);
            }

            if(!is_numeric($request->home_team_score) || !is_numeric($request->away_team_score)){
                return response()->json([
                    'status'=>false,
                    'message'=>'Scores must be numbers'
                ], 400);
            }


            $result = Result::find($id);
            if($result){
                //check if match exists
                $match = Fixture::find($request->match_id);
                if(!$match){
                    return response()->json([
                        'status'=>false,
                        'message'=>'Match not found'
                    ], 404);
                }
                $result->home_team_score = $request->home_team_score;
                $result->away_team_score = $request->away_team_score;
                $result->match_id = $request->match_id;
                $result->save();

                return response()->json([
                    'status'=>true,
                    'message'=>'Result updated',
                    'data'=>$result
                ], 200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Result not found'
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ]);
        }
    }

    public function deleteResult($id){
        try{
        

            $result = Result::find($id);
            if($result){
                $result->delete();
                return response()->json([
                    'status'=>true,
                    'message'=>'Result deleted'
                ], 200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Result not found'
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
