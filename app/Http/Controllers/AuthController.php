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
    public function logout()
    {
        FacadesAuth::logout();
        return redirect('login');
    }

    //  ADMIN DASHBOARD    
    public function adminDashboard(Request $request)
    {
        $category = Category::orderBy('cat_name')->get();
        $subject  = Subject::orderBy('sub_name')->get();
        $totalNotes    = Notes::where('status', 'Approved')->count();
        $totalSubjects = Subject::count();
        $totalCategory = Category::count();
        $totalUser     = User::where('role', 'User')->count();

        $notes = Notes::with('category', 'user', 'subject', 'filePath', 'youtubeLink')
                      ->where('status', 'Approved');

        if ($request->filled('search')) {            
            $search = $request->search;
            $notes->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('category')) {
            $notes->where('cat_id', $request->category);
        }

        if ($request->filled('subject')) {
            $notes->where('sub_id', $request->subject);
        }

        $notes = $notes->orderBy('id', 'desc')->paginate(10);

        return view('admin.dashboard', compact(
            'notes', 'totalCategory', 'totalNotes',
            'totalSubjects', 'totalUser', 'category', 'subject'
        ));
    }

    //  USER DASHBOARD
    public function userDashboard()
    {
        $userId = FacadesAuth::id();
        $publicNotesCount  = Notes::where('visibility', 'Public')->where('user_id', $userId)->count();
        $privateNotesCount = Notes::where('visibility', 'Private')->where('user_id', $userId)->count();
        $totalNotes        = Notes::where('user_id', $userId)->count();
        $favouriteCount    = Favourite::where('user_id', $userId)->count();

        $notes = Notes::with('filePath', 'subject', 'youtubeLink', 'user')
                      ->where('visibility', 'Public')
                      ->where('status', 'Approved')
                      ->latest()
                      ->take(12)
                      ->get();

        $favouriteNoteIds = Favourite::where('user_id', $userId)->pluck('notes_id')->flip();

        foreach ($notes as $n) {
            $n->is_favourite = $favouriteNoteIds->has($n->id);
        }

        return view('user.dashboard', compact(
            'privateNotesCount', 'publicNotesCount', 'totalNotes', 'notes', 'favouriteCount'
        ));
    }

    //  LOGIN
    public function loginPage()
    {
        return view('Authentication.login');
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (FacadesAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); 
            $role = FacadesAuth::user()->role;
            return redirect($role === 'Admin' ? 'admin_dashboard' : 'user_dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }

    //  REGISTER
    public function registerPage()
    {
        return view('Authentication.register');
    }

    public function processRegister(Request $request)
    {        
        $request->validate([
            'name'                  => 'required|min:3|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('login')->with('success', 'Registration successful. Please login.');
    }

    //  CHANGE PASSWORD
    public function showChangePasswordPage()
    {
        return view('Authentication.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:6',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        $redirect = $user->role === 'Admin' ? 'admin_dashboard' : 'user_dashboard';
        return redirect($redirect)->with('success', 'Password updated successfully');
    }

    //  CHANGE NAME

    public function showChangeNamePage()
    {
        return view('Authentication.change_name');
    }

    public function updateName(Request $request)
    {
        $request->validate(['name' => 'required|min:3|max:100']);

        $user = auth()->user();
        $user->name = $request->name;
        $user->save();

        $redirect = $user->role === 'Admin' ? 'admin_dashboard' : 'user_dashboard';
        return redirect($redirect)->with('success', 'Name updated successfully');
    }
}