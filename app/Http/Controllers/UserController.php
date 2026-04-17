<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Notes;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //function to view public notes page
    public function publicNotesPage(){
        $notes = Notes::with("filePath","category","subject","user")->where("visibility","Public")->where("status","Approved")->get();

        foreach($notes as $n){
            $n->is_favourite = Favourite::where("user_id", auth()->id())->where("notes_id", $n->id)->exists();
        }
        return view("user.public_notes",compact("notes"));
    }


    //function to add notes in favourite table
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


    //List of Favourite Notes
    public function favouriteList(Request $request){

        $search = $request->search;

        $favourite = Favourite::where("user_id",auth()->id())->pluck("notes_id");

        $notes = Notes::with("subject","category","filePath","user")->whereIn("id",$favourite);

        if ($search) {
            $notes->where(function ($q) {

                $q->where("title", "like", "%" . request('search') . "%")

                ->orWhereHas("subject", function ($q2) {
                    $q2->where("sub_name", "like", "%" . request('search') . "%");
                })

                ->orWhereHas("category", function ($q3) {
                    $q3->where("cat_name", "like", "%" . request('search') . "%");
                })

                ->orWhereHas("user", function ($q4) {
                    $q4->where("name", "like", "%" . request('search') . "%");
                });

            });
        }
        $notes = $notes->get();
        
        return view("user.favourite_list",compact("notes"));
    }
}
