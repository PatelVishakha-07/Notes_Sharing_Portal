<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Notes;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function publicNotesPage(){
        $notes = Notes::with("filePath","category","subject","user")->where("visibility","Public")->get();

        foreach($notes as $n){
            $n->is_favourite = Favourite::where("user_id", auth()->id())->where("notes_id", $n->id)->exists();
        }
        return view("user.public_notes",compact("notes"));
    }

    public function addToFavourite($id){
        $user_id = auth()->id();

        $existing = Favourite::where("user_id",$user_id)->where("notes_id",$id)->first();

        if($existing){
            $existing->delete();
            return response()->json([
                "status"=>"removed"
            ]);
        }
        else{
            Favourite::create([
                "user_id"=>$user_id,
                "notes_id"=>$id
            ]);

            return response()->json([
                "status"=>"added"
            ]);
        }
    }
}
