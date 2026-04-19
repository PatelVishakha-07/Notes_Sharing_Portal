<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Notes;
use App\Models\RejectedNotes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showUserList(Request $request){
        //$users = User::where("role","User")->withCount('notes');
        $users = User::where("role","User")
        ->withCount(['notes','notes as approved_notes_count' => function($q){
             $q->where('status', "Approved"); }, "rejectedNotes"
             ]);


        if($request->search){
            $users->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $users->paginate(10);

        return view("admin.list_user", compact("users"));
    }

    public function showPendingNotesList(){
        $pending_notes = Notes::with("user","category","subject","filePath","youtubeLink")->where("status","Pending")->paginate(10);
        return view("admin.pending_notes", compact("pending_notes"));
    }

    public function acceptRequest($val, $id){
        if($val == 1){
            $notes = Notes::find($id);
            $notes->status = 'Approved';
            $notes->save();
        }
        else if($val==0){
            $notes = Notes::find($id);
            $notes->status = 'Rejected';
            $notes->save();

            $user_id = $notes->user_id;

            RejectedNotes::create(["notes_id"=>$id, "user_id"=>$user_id]);

        }
        return redirect("admin/showPendingNotesList");
    }


    public function toggleUserStatus($id){
        $user = User::find($id);

        $user->status = $user->status == 1 ? 2 : 1;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully');
    }
}
