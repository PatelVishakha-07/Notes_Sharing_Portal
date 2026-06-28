<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\RejectedNotes;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // =========================================================
    //  USERS LIST
    // =========================================================
    public function showUserList(Request $request)
    {
        $users = User::where('role', 'User')
            ->withCount([
                'notes',
                // counts only approved notes
                'notes as approved_notes_count' => fn($q) => $q->where('status', 'Approved'),
                // uses the rejectedNotes relation on User model
                'rejectedNotes as rejected_notes_count',
            ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $users->where(function ($q) use ($search) {
                $q->where('name',  'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $users->paginate(10);

        return view('admin.list_user', compact('users'));
    }

    // =========================================================
    //  PENDING NOTES
    // =========================================================
    public function showPendingNotesList()
    {
        $pending_notes = Notes::with('user', 'category', 'subject', 'filePath', 'youtubeLink')
            ->where('status', 'Pending')
            ->latest()
            ->paginate(10);

        return view('admin.pending_notes', compact('pending_notes'));
    }

    // =========================================================
    //  APPROVE / REJECT NOTE
    //
    //  NOTE: the pending_notes blade was changed to use POST forms.
    //  Update your route to Route::post() to match, e.g.:
    //    Route::post('admin/acceptRequest/{val}/{id}', [AdminController::class,'acceptRequest']);
    // =========================================================
    public function acceptRequest($val, $id)
    {
        $notes = Notes::find($id);

        if (!$notes) {
            return redirect('admin/showPendingNotesList')
                ->with('error', 'Note not found');
        }

        if ($val == 1) {
            $notes->status = 'Approved';
            $notes->save();
        } elseif ($val == 0) {
            $notes->status = 'Rejected';
            $notes->save();

            RejectedNotes::create([
                'notes_id' => $notes->id,
                'user_id'  => $notes->user_id,
            ]);
        }

        return redirect('admin/showPendingNotesList')
            ->with('success', $val == 1 ? 'Note approved' : 'Note rejected');
    }

    //  TOGGLE USER STATUS
    public function toggleUserStatus($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->status = $user->status == 1 ? 2 : 1;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully');
    }
}