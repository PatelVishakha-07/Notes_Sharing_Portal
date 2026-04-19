<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favourite;
use App\Models\Notes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;

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

            $notes->where('title', 'like', '%' . $request->search .'%')
            ->orWhereHas("user",function ($q) {
                $q->where("name","like","%".request("search")."%");
            });
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

        $is_email_exists = User::where("email",$request->email)->first();

        if($is_email_exists)
            return back()->with("error","Email-Id already exists");

        if($request->password != $request->password_confirmation)
            return back()->with("error","Password and Confirm password doesn't match");
        

        User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$request->password
        ]);

        return redirect("login")->with("success","Registration successful. Please login.");
    }

    public function showChangePasswordPage(){
        return view("Authentication.change_password");
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "current_password" => "required|min:6",
            "new_password" => "required|min:6",
            "confirm_password" => "required|min:6"
        ]);

        $user = auth()->user();

        if(!Hash::check($request->current_password, $user->password))
            return back()->with("error", "Incorrect Password! Please enter correct password");
        

        if($request->new_password != $request->confirm_password){
            return back()->with("error", "Password and Confirm Password doesn't match");
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        if($user->role == 'Admin')
            return redirect('admin_dashboard')->with('success', 'Password updated successfully');
        else 
            return redirect('user_dashboard')->with('success', 'Password updated successfully');
        
    }

    public function showChangeNamePage(){
        return view("Authentication.change_name");
    }

    public function updateName(Request $request){
        $request->validate(["name"=>"required|min:3"]);

        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->save();

        if($user->role == 'Admin')
            return redirect('admin_dashboard')->with('success', 'Name updated successfully');
        else 
            return redirect('user_dashboard')->with('success', 'Name updated successfully');
        
    }
    
}