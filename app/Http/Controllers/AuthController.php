<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favourite;
use App\Models\Notes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthController extends Controller
{

    public function logout(){
        FacadesAuth::logout();
        return redirect("login");
    }

    public function adminDashboard(Request $request){

        $category = Category::get();
        $subject = Subject::get();
        $totalNotes = Notes::where("status","Approved")->get()->count();
        $totalSubjects = Subject::get()->count();
        $totalCategory = Category::get()->count();
        $totalUser = User::where("role","User")->count();


        $notes = Notes::with("category","user","subject","filePath","youtubeLink")->where("status","Approved");

        if($request->search){
            $notes->where('title', 'like', '%' . $request->search .'%');
        }

        if($request->category){
            $notes->where('cat_id', $request->category);
        }

        if($request->subject){
            $notes->where('sub_id', $request->subject);
        }        

        $notes = $notes->orderBy('id', 'desc')->paginate(10);
        
        return view('admin.dashboard', compact("notes","totalCategory", "totalNotes", 'totalSubjects', "totalUser", "category","subject"));
    }

    public function userDashboard(){
        $publicNotesCount = Notes::where("visibility","Public")->where("user_id",FacadesAuth::user()->id)->get()->count();
        $privateNotesCount = Notes::where("visibility","Private")->where("user_id",FacadesAuth::user()->id)->get()->count();
        $totalNotes = Notes::where("user_id",FacadesAuth::user()->id)->get()->count();
        
        $notes = Notes::with('filePath', 'subject')->where('visibility', 'Public')->where("status","Approved")->get();

        $favouriteCount = Favourite::where("user_id",auth()->id())->get()->count();

        foreach($notes as $n){
            $n->is_favourite = Favourite::where("user_id", auth()->id())->where("notes_id", $n->id)->exists();
        }


        return view("user.dashboard", compact("privateNotesCount","publicNotesCount","totalNotes","notes","favouriteCount"));
    }

    public function loginPage(){
        return view("Authentication.login");
    }

    public function processLogin(Request $request){

        $request->validate([
            "email"=>"required",
            "password"=>"required|min:6"
        ]);        
       

        if (FacadesAuth::attempt([
            "email"=>$request->email,
            "password"=>$request->password]))
        {
            $role = FacadesAuth::user()->role;
            if($role == "Admin"){
                return redirect("admin_dashboard");
            }else{
                return redirect("user_dashboard");
            }
        }
        return back()->with("error","Invalid email or password");
    }

    public function registerPage(){
        return view("Authentication.register");
    }

    public function processRegister(Request $request){
        $request->validate([
            "name"=>"required",
            "email"=>"required|email",
            "password"=>"required|min:6",
            "password_confirmation"=>"required|min:6"
        ]);

        if($request->password != $request->password_confirmation){
            return back()->with("error","Password and Confirm password doesn't match");
        }

        User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$request->password
        ]);

        return redirect("login")->with("success","Registration successful. Please login.");
    }

    
}