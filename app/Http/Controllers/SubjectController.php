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
}
