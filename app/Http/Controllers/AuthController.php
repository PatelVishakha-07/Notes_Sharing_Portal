<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Notes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthController extends Controller
{

    public function logout(){
        FacadesAuth::logout();
        return redirect("login");
    }

    public function adminDashboard(){
        $totalNotes = Notes::get()->count();
        $totalSubjects = Subject::get()->count();
        $totalCategory = Category::get()->count();
        $totalUser = User::where("role","User")->count();
        return view("admin.dashboard", compact("totalSubjects","totalCategory","totalUser","totalNotes"));
    }

    public function userDashboard(){
        $publicNotesCount = Notes::where("visibility","Public")->where("user_id",FacadesAuth::user()->id)->get()->count();
        $privateNotesCount = Notes::where("visibility","Private")->get()->count();
        $totalNotes = Notes::where("user_id",FacadesAuth::user()->id)->get()->count();
        return view("user.dashboard", compact("privateNotesCount","publicNotesCount","totalNotes"));
    }

    public function loginPage(){
        return view("Authentication.login");
    }

    public function processLogin(Request $request){

        // echo "<pre>";
        // print_r($request->all());
        // print_r(FacadesAuth::user()->role);
        // die;

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