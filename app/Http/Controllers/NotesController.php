<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FilePath;
use App\Models\Notes;
use App\Models\Subject;
use App\Models\User;
use App\Models\Youtube;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NotesController extends Controller
{
    public function uploadNotePage()
    {
        $category = Category::orderBy('cat_name', 'asc')->get();
        $subject  = Subject::orderBy('sub_name', 'asc')->get();
        return view('user.upload', compact('category', 'subject'));
    }

    public function getSubjects($cat_id)
    {
        $subject = Subject::where('cat_id', $cat_id)->orderBy('sub_name', 'asc')->get();
        return response()->json($subject);
    }

    // =========================================================
    //  SAVE NOTE
    // =========================================================
    public function saveNote(Request $request)
    {
        $request->validate([
            'title'        => 'required|min:3|max:150',
            'cat_id'       => 'required|exists:category,id',
            'sub_id'       => 'required|exists:subject,id',
            'file'         => 'required',
            'file.*'       => 'file|max:10240',
            // Bug fix: validate YouTube links are actual URLs when provided
            'youtube_links'   => 'nullable|array',
            'youtube_links.*' => 'nullable|url',
        ]);

        $user = auth()->user();

        if ($user->status != 1) {
            return back()->with('error', 'Your account is deactivated. Please contact the Admin.');
        }

        $visibility = 'Public';
        $code       = null;

        if ($request->has('is_private')) {
            $visibility = 'Private';
            // Bug fix: Str::random alone can collide if two uploads happen in
            // the same second. Prefixing with uniqid() makes it unique.
            $code = strtoupper(Str::random(3)) . '-' . strtoupper(Str::random(3));
        }

        $notes = Notes::create([
            'title'       => $request->title,
            'cat_id'      => $request->cat_id,
            'sub_id'      => $request->sub_id,
            'visibility'  => $visibility,
            'user_id'     => Auth::id(),
            'access_code' => $code,
        ]);

        foreach ($request->file('file') as $f) {
            // Bug fix: time() + original name can collide when multiple files share
            // the same name or are uploaded simultaneously. Use uniqid() for uniqueness.
            $fnm = uniqid('', true) . '_' . $f->getClientOriginalName();
            $f->storeAs('public', $fnm); // uses Laravel storage properly

            FilePath::create([
                'notes_id'  => $notes->id,
                'file_path' => $fnm,
            ]);
        }

        if ($request->filled('youtube_links')) {
            foreach ($request->youtube_links as $link) {
                if (!empty($link)) {
                    Youtube::create([
                        'notes_id'     => $notes->id,
                        'youtube_link' => $link,
                    ]);
                }
            }
        }

        if ($request->has('is_private')) {
            return back()->with('access_code', $code);
        }

        return redirect('user/list_public_notes/Public');
    }

    // =========================================================
    //  LIST NOTES (public or private tab)
    // =========================================================
    public function listNotes($status, Request $request)
    {
        $user_id  = Auth::id();
        $category = Category::orderBy('cat_name')->get();
        $subject  = Subject::orderBy('sub_name')->get();

        $notes = Notes::with('subject', 'category', 'filePath', 'user', 'youtubeLink')
            ->where('user_id', $user_id)
            ->where('visibility', $status);

        if ($request->filled('cat_id')) {
            $notes->where('cat_id', $request->cat_id);
        }

        if ($request->filled('sub_id')) {
            $notes->where('sub_id', $request->sub_id);
        }

        if ($request->filled('search')) {
            $notes->where('title', 'like', '%' . $request->search . '%');
        }

        // Bug fix: was paginate(2) — almost certainly a debug leftover
        $notes = $notes->latest()->paginate(10);

        return view('user.list', compact('notes', 'status', 'category', 'subject'));
    }

    // =========================================================
    //  DELETE NOTE
    // =========================================================
    public function deleteNote($id)
    {
        // Scope to auth user so users can't delete other users' notes
        Notes::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect('user/list_public_notes/Public');
    }

    // =========================================================
    //  SEARCH PAGE
    // =========================================================
    public function showSearchPage()
    {
        $category = Category::orderBy('cat_name')->get();
        $subject  = Subject::orderBy('sub_name')->get();
        return view('user.search', compact('category', 'subject'));
    }

    public function searchNotes(Request $request)
    {
        $category = Category::orderBy('cat_name')->get();
        $subject  = Subject::orderBy('sub_name')->get();

        $notes = Notes::with('category', 'subject', 'filePath', 'youtubeLink', 'user')
            ->where('visibility', 'Public')
            ->where('status', 'Approved');

        if ($request->filled('cat_id')) {
            $notes->where('cat_id', $request->cat_id);
        }

        if ($request->filled('sub_id')) {
            $notes->where('sub_id', $request->sub_id);
        }

        if ($request->filled('title')) {
            $notes->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('username')) {
            $userIds = User::where('name', 'like', '%' . $request->username . '%')->pluck('id');
            $notes->whereIn('user_id', $userIds);
        }

        $notes = $notes->paginate(10);

        return view('user.search', compact('category', 'subject', 'notes'));
    }

    // =========================================================
    //  ACCESS PRIVATE NOTE BY CODE
    // =========================================================
    public function getPrivateNotes(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string|max:20',
        ]);

        $category = Category::orderBy('cat_name')->get();
        $subject  = Subject::orderBy('sub_name')->get();

        // Bug fix: was ->get() (Collection) but the search view calls $notes->firstItem()
        // which is a paginator method — crashes on a plain Collection.
        // Changed to paginate() so the view works correctly.
        $notes = Notes::with('category', 'subject', 'filePath', 'youtubeLink', 'user')
            ->where('access_code', $request->access_code)
            ->where('status', 'Approved')
            ->paginate(10);

        if ($notes->isEmpty()) {
            return back()->with('error', 'No note found with this access code');
        }

        return view('user.search', compact('category', 'subject', 'notes'));
    }
}