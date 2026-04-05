<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showUserList(){
        $user = User::where("role","User")->get();
        return view("admin.list_user", compact("user"));
    }

    public function showPendingNotesList(){
        $pending_notes = Notes::with("user","category","subject","filePath")->where("status","Pending")->get();
        return view("admin.pending_notes", compact("pending_notes"));
    }

    public function acceptRequest($val, $id){
        if($val == 1){
            $notes = Notes::find($id);
            $notes->status = 'Approved';
            $notes->save();
        }
        else if($val==0){

        }
        return redirect("admin/showPendingNotesList");
    }
}
