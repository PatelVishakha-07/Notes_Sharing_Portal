<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favourite;
use App\Models\Notes;
use App\Models\Subject;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //function to view public notes page
    public function publicNotesPage(Request $request){
        $category = Category::get();
        $subject = Subject::get();
        $notes = Notes::with("filePath","category","subject","user","youtubeLink")->where("visibility","Public")->where("status","Approved");

        if($request->search){
            $notes = $notes->where("title","like","%".$request->search."%");
        }

        if($request->category){
            $notes = $notes->where("cat_id",$request->category);
        }

        if($request->subject){
            $notes = $notes->where("sub_id",$request->subject);
        }

        //$notes = $notes->get();
        $notes = $notes->paginate(20);

        foreach($notes as $n){
            $n->is_favourite = Favourite::where("user_id", auth()->id())->where("notes_id", $n->id)->exists();
        }


        return view("user.public_notes",compact("notes","category", "subject"));
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
