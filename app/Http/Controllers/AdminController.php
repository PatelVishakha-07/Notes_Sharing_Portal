<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function showUserList(){
        $totalUser = User::where("role","User")->count();
        return view("admin.list_user", compact("totalUser"));
    }

    public function showPendingNotesList(){
        $pending_notes = Notes::with("user","category","subject","filePath")->where("status","Pending")->get();
        return view("admin.pending_notes", compact("pending_notes"));
    }

    public function acceptRequest(){
        
    }
}
