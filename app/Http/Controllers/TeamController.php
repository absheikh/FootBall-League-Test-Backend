<?php

namespace App\Models\Team;
namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    public function getTeams(){

        try{
        $teams = Team::all();
            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>$teams
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ]);
            
        }
   }

   public function getTeam($id){
        try{
           
            $team = Team::find($id);
            if($team){
                return response()->json([
                    'status'=>true,
                    'message'=>'Fetched',
                    'data'=>$team
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Team not found'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ]);
        }
   }

    public function createTeam(Request $request){
          try{

            if(!$request->name || !$request->city || !$request->hasFile('logo')){
                return response()->json([
                    'status'=>false,
                    'message'=>'All fields are required'
                ],
                400);
            }

            //if the team name already exists
            $team = Team::where('team_name', $request->name)->first();
            if($team){
                return response()->json([
                    'status'=>false,
                    'message'=>'Team already exists'
                ], 400
            ); 
            }

            

                $file = $request->file('logo');
                $filename = $request->file('logo')->getClientOriginalName();
                $newFilename = time().'_'.$filename;
                $ext = $request->file('logo')->getClientOriginalExtension();
                if($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg'){
                    return response()->json([
                        'status'=>false,
                        'message'=>'Invalid file type'
                    ], 400
                );
                }
                $file->move('storage/teams', $newFilename);


                $team = new Team();
                $team->team_name = $request->name;
                $team->city = $request->city;
                $team->logo_url = 'storage/teams/'.$newFilename;
                $team->save();


                return response()->json([
                 'status'=>true,
                 'message'=>'Team created',
                 'data'=>$team
                ], 201
            );

          }catch(\Exception $e){
                return response()->json([
                 'status'=>false,
                 'message'=>'Server error'
                ], 500
            );
          }
    }

    public function updateTeam(Request $request, $id){
        try{

               //if the team name already exists and is not the current team 
            $exist = Team::where('team_name', $request->name)->where('id', '!=', $id)->first();
            if($exist){
                return response()->json([
                    'status'=>false,
                    'message'=>'Team already exists'
                ], 400
            );
            }

            if(!$request->name || !$request->city){
                return response()->json([
                    'status'=>false,
                    'message'=>'All fields are required'
                ], 400
            );
            }

         


        

            $team = Team::find($id);
            if($team){
                $team->team_name = $request->name;
                $team->city = $request->city;
              
                $team->save();
                return response()->json([
                    'status'=>true,
                    'message'=>'Team updated',
                    'data'=>$team
                ],
                200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Team not found'
                ],404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ],
            500);
        }
    }

    public function deleteTeam($id){
        try{
          

            $team = Team::find($id);
            if($team){
                $team->delete();
                return response()->json([
                    'status'=>true,
                    'message'=>'Team deleted'
                ],
                200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Team not found'
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
