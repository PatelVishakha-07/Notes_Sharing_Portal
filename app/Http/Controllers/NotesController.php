<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FilePath;
use App\Models\Notes;
use App\Models\Subject;
use App\Models\User;
use App\Models\Youtube;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


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

        // echo "<pre>";
        // print_r($request->all());die;
        $code = null;
        $visibility = "Public";       

        $request->validate([
            "title"=>"required|min:3",
            "cat_id"=>"required",
            "sub_id"=>"required",
            "file"=>"required"
        ]);

        if($request->has("is_private")){
            $visibility = "Private";
            $code = strtoupper(Str::random(3))."-".strtoupper(Str::random(3));
        }


        $notes = Notes::create([
            "title"=>$request->title,
            "cat_id"=>$request->cat_id,
            "sub_id"=>$request->sub_id,
            "visibility" => $visibility,
            "user_id"=>Auth::id(),
            "access_code"=>$code
        ]);

        foreach($request->file("file") as $f){
            $fnm = time().$f->getClientOriginalName();
            $f->move(public_path("storage"),$fnm);

            FilePath::create([
                "notes_id"=>$notes->id,
                "file_path"=>$fnm
            ]);            
        }

        if($request->youtube_links){
            foreach($request->youtube_links as $link){
                Youtube::create([
                    "notes_id"=>$notes->id,
                    "youtube_link"=>$link
                ]);
            }
        }

        if($request->has("is_private")){
            return back()->with("access_code",$code);
        }

        return redirect("user/list_public_notes/Public");
    }

    public function listNotes($status, Request $request)
    {
        $user_id = Auth::id();

        $category = Category::get();
        $subject = Subject::get();

        // STEP 1: Base query with strict status separation
        $notes = Notes::with("subject","category","filePath","user","youtubeLink")
                    ->where("user_id", $user_id)
                    ->where("visibility", $status); // 👈 THIS keeps Public/Private separate

        // STEP 2: Filters inside same status
        if ($request->cat_id) {
            $notes->where("cat_id", $request->cat_id);
        }

        if ($request->sub_id) {
            $notes->where("sub_id", $request->sub_id);
        }

        if ($request->search) {
            $notes->where("title", "like", "%".$request->search."%");
        }

        // STEP 3: Final result
        $notes = $notes->latest()->get();

        return view("user.list", compact("notes","status","category","subject"));
    }

    public function deleteNote($id){
        Notes::where("id",$id)->delete();
        return redirect("user/list_public_notes/Public");
    }

    public function showSearchPage(){
        $category = Category::get();
        $subject = Subject::get();
        return view("user.search", compact("category","subject"));
    }

    public function searchNotes(Request $request){
       
        $category = Category::get();
        $subject = Subject::get();
        $notes = Notes::with("category","subject","filePath","youtubeLink")->where("visibility","Public")->where("status","Approved");
        
        if($request->cat_id){
            $notes = $notes->where("cat_id",$request->cat_id);
        }
        if($request->sub_id){
            $notes = $notes->where("sub_id",$request->sub_id);
        }
        if($request->title){
            $notes = $notes->where("title","like","%".$request->title."%");
        }

        if($request->username){
            $userId = User::where('name', 'like', '%' . $request->username . '%')->pluck("id");
            $notes = $notes->whereIn("user_id",$userId);
        }

        $notes = $notes->get();

        return view("user.search", compact("category","subject","notes"));
    }

    public function getPrivateNotes(Request $request){
        $category = Category::get();
        $subject = Subject::get();
        $notes = Notes::with("category","subject","filePath","youtubeLink")->where("access_code",$request->access_code)
        ->where("status","Approved")->get();
        return view("user.search", compact("category","subject","notes"));
    }
}
