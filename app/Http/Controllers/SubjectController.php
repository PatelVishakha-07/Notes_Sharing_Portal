<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function addSubjectPage()
    {
        $category = Category::orderBy('cat_name')->get();
        return view('admin.subject.add_subject', compact('category'));
    }

    public function saveSubject(Request $request)
    {
        $request->validate([
            'sub_name' => 'required|max:100',
            'cat_id'   => 'required|exists:category,id',
        ]);

        $exists = Subject::whereRaw('LOWER(sub_name) = ?', [strtolower($request->sub_name)])
            ->where('cat_id', $request->cat_id)
            ->first();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', "\"{$request->sub_name}\" subject already exists in this category");
        }

        Subject::create([
            'sub_name' => $request->sub_name,
            'cat_id'   => $request->cat_id,
        ]);

        return redirect('list_subject')->with('success', 'Subject added successfully');
    }

    public function listSubject()
    {
        $subject = Subject::with('category')->orderBy('sub_name')->paginate(10);
        return view('admin.subject.list_subject', compact('subject'));
    }

    public function deleteSubject($id)
    {
        $subject = Subject::find($id);

        if (!$subject) {
            return redirect('list_subject')->with('error', 'Subject not found');
        }

        $subject->delete();

        // Bug fix: was ->with("Subject deleted successfully") — with() needs key+value
        return redirect('list_subject')->with('success', 'Subject deleted successfully');
    }

    public function editSubjectPage($id)
    {
        $category = Category::orderBy('cat_name')->get();
        $subject  = Subject::findOrFail($id);
        return view('admin.subject.edit', compact('subject', 'category'));
    }

    public function editSubject(Request $request)
    {
        $request->validate([
            'sub_name' => 'required|max:100',
            'cat_id'   => 'required|exists:category,id',
        ]);

        // Critical bug fix: was querying Category model instead of Subject.
        // Category has no sub_name column — this either always returned null
        // (never blocking duplicates) or caused a SQL error.
        // Also added exclude-self so renaming without changing is not blocked.
        $exists = Subject::whereRaw('LOWER(sub_name) = ?', [strtolower($request->sub_name)])
            ->where('cat_id', $request->cat_id)
            ->where('id', '!=', $request->id)
            ->first();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', "\"{$request->sub_name}\" subject already exists in this category");
        }

        $subject = Subject::findOrFail($request->id);
        $subject->sub_name = $request->sub_name;
        $subject->cat_id   = $request->cat_id;
        $subject->save();

        return redirect('list_subject')->with('success', 'Subject updated successfully');
    }
}