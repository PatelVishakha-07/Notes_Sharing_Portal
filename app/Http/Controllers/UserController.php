<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favourite;
use App\Models\Notes;
use App\Models\ProfilePic;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Bug fix: removed unused import App\Models\Profile

class UserController extends Controller
{
    // =========================================================
    //  PUBLIC NOTES PAGE
    // =========================================================
    public function publicNotesPage(Request $request)
    {
        $category = Category::orderBy('cat_name')->get();
        $subject  = Subject::orderBy('sub_name')->get();

        $notes = Notes::with('filePath', 'category', 'subject', 'user', 'youtubeLink')
            ->where('visibility', 'Public')
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

        $notes = $notes->latest()->paginate(20);

        // Bug fix: replace N+1 favourite loop with a single query
        $favouriteNoteIds = Favourite::where('user_id', auth()->id())->pluck('notes_id')->flip();

        foreach ($notes as $n) {
            $n->is_favourite = $favouriteNoteIds->has($n->id);
        }

        return view('user.public_notes', compact('notes', 'category', 'subject'));
    }

    // =========================================================
    //  TOGGLE FAVOURITE
    // =========================================================
    public function addToFavourite($id)
    {
        $user_id  = auth()->id();
        $existing = Favourite::where('user_id', $user_id)->where('notes_id', $id)->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed']);
        }

        Favourite::create(['user_id' => $user_id, 'notes_id' => $id]);
        return response()->json(['status' => 'added']);
    }

    // =========================================================
    //  FAVOURITE LIST
    // =========================================================
    public function favouriteList(Request $request)
    {
        $favouriteIds = Favourite::where('user_id', auth()->id())->pluck('notes_id');

        $notes = Notes::with('subject', 'category', 'filePath', 'user', 'youtubeLink')
            ->whereIn('id', $favouriteIds);

        if ($request->filled('search')) {
            // Bug fix: capture $search in scope instead of using global request()
            // helper inside nested closures — cleaner and avoids stale request state
            $search = $request->search;
            $notes->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('subject',  fn($q2) => $q2->where('sub_name', 'like', "%{$search}%"))
                  ->orWhereHas('category', fn($q3) => $q3->where('cat_name', 'like', "%{$search}%"))
                  ->orWhereHas('user',     fn($q4) => $q4->where('name',     'like', "%{$search}%"));
            });
        }

        $notes = $notes->latest()->paginate(20);

        return view('user.favourite_list', compact('notes'));
    }

    // =========================================================
    //  UPDATE PROFILE PICTURE
    // =========================================================
    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_pic' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $img    = $request->file('profile_pic');
        $imgNm  = uniqid('profile_', true) . '.' . $img->getClientOriginalExtension();

        $img->move(public_path('profile'), $imgNm);

        $profile = ProfilePic::where('user_id', auth()->id())->first();

        if ($profile) {
            // Bug fix: delete the old file from disk before replacing it —
            // otherwise old profile pictures accumulate indefinitely in public/profile
            $oldPath = public_path('profile/' . $profile->profile_pic);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }

            $profile->profile_pic = $imgNm;
            $profile->save();
        } else {
            ProfilePic::create([
                'user_id'     => auth()->id(),
                'profile_pic' => $imgNm,
            ]);
        }

        return back()->with('success', 'Profile picture updated successfully');
    }
}