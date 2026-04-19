<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function addSubjectPage(){
        $category = Category::get();
        return view("admin.subject.add_subject",compact("category"));
    }

    public function saveSubject(Request $request){
        $request->validate([
            "sub_name"=>"required",
            "cat_id"=>"required"
        ]);

        $is_subject_exists = Subject::where("sub_name",$request->sub_name)->where("cat_id",$request->cat_id)->first();

        if($is_subject_exists) 
            return back()->with("error","Subject already exists");

        Subject::create([
            "sub_name"=>$request->sub_name,
            "cat_id" => $request->cat_id
        ]);

        return redirect("list_subject");
    }

    public function listSubject(){
        $subject = Subject::with("category")->get();
        return view("admin.subject.list_subject",compact("subject"));
    }

    public function deleteSubject($id){
        Subject::find($id)->delete();
        return redirect("list_subject")->with("Subject deleted successfully");
    }

    public function editSubjectPage($id){
        $category = Category::get();
        $subject = Subject::find($id);
        return view("admin.subject.edit", compact("subject","category"));
    }

    public function editSubject(Request $request){
        $request->validate([
            "sub_name"=>"required",
            "cat_id"=>"required"
        ]);

       $is_subject_exists = Category::where("sub_name",$request->sub_name)->where("cat_id",$request->cat_id)->first();

        if($is_subject_exists) 
            return back()->with("error", $request->sub_name." Subject already exists");

        $subject = Subject::find($request->id);
        $subject->sub_name = $request->sub_name;
        $subject->cat_id = $request->cat_id;
        $subject->save();

        return redirect("list_subject");
    }
}
