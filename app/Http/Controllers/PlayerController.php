<?php

namespace App\Http\Controllers;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function getPlayers(){
        try{
            //get players with their team
            $players = Player::with('team')->get();

            return response()->json([
                'status'=>true,
                'message'=>'Fetched',
                'data'=>$players
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    public function getPlayer($id){
        try{
            $player = Player::find($id);
            if($player){
                return response()->json([
                    'status'=>true,
                    'message'=>'Fetched',
                    'data'=>$player
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Player not found'
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }


    public function createPlayer(Request $request){
        try{
          if(!$request->name || !$request->position || !$request->nationality || !$request->jersey_number || !$request->team_id || !$request->hasFile('image')){
                return response()->json([
                    'status'=>false,
                    'message'=>'All fields are required'
                ], 400);
            }

            //if the team does not exist
            if(!Team::find($request->team_id)){
                return response()->json([
                    'status'=>false,
                    'message'=>'Team not found'
                ], 404);
            }
            //if the player already exists in the team
            $player = Player::where('player_name', $request->name)->where('team_id', $request->team_id)->first();
            if($player){
                return response()->json([
                    'status'=>false,
                    'message'=>'Player already exists in the team'
                ], 400);
            }

            $file = $request->file('image');
            $image = time().'_'.$file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png'){
                return response()->json([
                    'status'=>false,
                    'message'=>'Invalid image format'
                ], 400);
            }
            $file->move('storage/players', $image);

            $player = new Player();
            $player->player_name = $request->name;
            $player->position = $request->position;
            $player->nationality = $request->nationality;
            $player->jersey_number = $request->jersey_number;
            $player->team_id = $request->team_id;
            $player->image_url = 'storage/players/'.$image;
            $player->save();

            return response()->json([
                'status'=>true,
                'message'=>'Player created',
                'data'=>$player
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    public function updatePlayer(Request $request, $id){
        try{
            
            if(!$request->name || !$request->position || !$request->nationality || !$request->jersey_number || !$request->team_id){
                return response()->json([
                    'status'=>false,
                    'message'=>'All fields are required'
                ], 400);
            }

            $player = Player::find($id);
            if($player){
                $team = Team::find($request->team_id);
                if(!$team){
                    return response()->json([
                        'status'=>false,
                        'message'=>'Team not found'
                    ],404);
                }
                $player->player_name = $request->name;
                $player->position = $request->position;
                $player->nationality = $request->nationality;
                $player->jersey_number = $request->jersey_number;
                $player->team_id = $request->team_id;
                $player->save();

                return response()->json([
                    'status'=>true,
                    'message'=>'Player updated',
                    'data'=>$player
                ], 200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Player not found'
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Server error'
            ], 500);
        }
    }

    public function deletePlayer($id){
        try{
          
            $player = Player::find($id);
            if($player){
                $player->delete();
                return response()->json([
                    'status'=>true,
                    'message'=>'Player deleted'
                ], 200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Player not found'
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



