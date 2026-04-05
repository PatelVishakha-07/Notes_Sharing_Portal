<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FilePath;
use App\Models\Notes;
use App\Models\Subject;
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
            "title"=>"required",
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

        if($request->has("is_private")){
            return back()->with("access_code",$code);
        }

        return redirect("user/list_public_notes/Public");
    }

    public function listNotes($status){
        $user_id = Auth::id();
        
        if($status == "Public"){
            $notes = Notes::with("subject","category","filePath","user")->where("user_id",$user_id)->where("visibility","Public")->get();
        }else{
            $notes = Notes::with("subject","category","filePath","user")->where("user_id",$user_id)->where("visibility","Private")->get();
        }
        return view("user.list", compact("notes","status"));
    }

    public function deleteNote($id){
        Notes::where("id",$id)->delete();
        return redirect("user/list_public_notes/Public");
    }
}
