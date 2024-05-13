<?php

namespace App\Http\Controllers;
use App\Models\Standing;
use App\Models\Team;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    public function getStandings(){
        try{
            //standings with team details
            $standings = Standing::with('team')->get();

            //now based on the points, sort the standings based on the highest points
            $standings = $standings->sortByDesc('points')->values()->all();

        

            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>$standings
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ],500);
        }
    }

    public function getStanding($id){
        try{
            $standing = Standing::find($id);
            if($standing){
                return response()->json([
                    'status'=>true,
                    'message'=>'Fetched',
                    'data'=>$standing
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Standing not found'
                ,404]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ],500);
        }
    }

    public function createStanding(Request $request){
        try{
          
            if(!$request->team_id || !$request->won || !$request->drawn || !$request->lost){
                return response()->json([
                    'status'=>false,
                    'message'=>'All fields are required'
                ],400);
            }
            //check if the team_id exists in the teams table
            $team = Team::find($request->team_id);
            if(!$team){
                return response()->json([
                    'status'=>false,
                    'message'=>'Team not found'
                ],404);
            }
            $standing = new Standing();
            $standing->team_id = $request->team_id;
            $standing->won = $request->won;
            $standing->drawn = $request->drawn;
            $standing->lost = $request->lost;

            $total_points = ($request->won * 3) + $request->drawn; 
            $standing->points = $total_points;
            $standing->save();
            return response()->json([
                'status'=>true,
                'message'=>'Standing created',
                'data'=>$standing
            ],201);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error '.$e->getMessage()
            ],500);
        }
    }

    public function updateStanding(Request $request, $id){
        try{
            $standing = Standing::find($id);
            if($standing){
                  
                    if(!$request->team_id || !$request->won || !$request->drawn || !$request->lost){
                    return response()->json([
                        'status'=>false,
                        'message'=>'All fields are required'
                    ],400);
                    }
                     //check if the team_id exists in the teams table
                    $team = Team::find($request->team_id);
                    if(!$team){
                        return response()->json([
                            'status'=>false,
                            'message'=>'Team not found'
                        ],404);
                    }
                $standing->team_id = $request->team_id;
                $standing->won = $request->won;
                $standing->drawn = $request->drawn;
                $standing->lost = $request->lost;

                $total_points = ($request->won * 3) + $request->drawn;
                $standing->points = $total_points;
                
                $standing->save();
                return response()->json([
                    'status'=>true,
                    'message'=>'Standing updated',
                    'data'=>$standing
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Standing not found'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ],500);
        }
    }

    public function deleteStanding($id){
        try{
            $standing = Standing::find($id);
            if($standing){
                $standing->delete();
                return response()->json([
                    'status'=>true,
                    'message'=>'Standing deleted'
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Standing not found'
                ],404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ],500);
        }
    }

}
