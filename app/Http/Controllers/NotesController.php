<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FilePath;
use App\Models\Notes;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function uploadNotePage(){
        $category = Category::get();
        $subject = Subject::get();
        return view("user.upload", compact("category","subject"));
    }

    public function getSubjects($cat_id){
        $subject = Subject::where("cat_id",$cat_id)->get();
        return response()->json($subject);
    }

    public function saveNote(Request $request){
        $request->validate([
            "title"=>"required",
            "cat_id"=>"required",
            "sub_id"=>"required",
            "file"=>"required"
        ]);


        $notes = Notes::create([
            "title"=>$request->title,
            "cat_id"=>$request->cat_id,
            "sub_id"=>$request->sub_id,
            "visibility"=>$request->visibility,
            "user_id"=>Auth::user()
        ]);

        foreach($request->file("file") as $f){
            $fnm = time().$f->getClientOriginalName();
            $f->move(public_path("storage"),$fnm);

            FilePath::create([
                "notes_id"=>$notes,
                "file_path"=>$fnm
            ]);
        }
    }

    public function listNotes(){
        $user_id = Auth::id();
        $notes = Notes::with("subject","category","filePath","user")->where("user_id",$user_id)->get();
        return view("user.list", compact("notes"));
    }
}
