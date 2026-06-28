<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Bug fix: removed dead checkAdmin() method — auth is handled by the
    // isAdmin middleware on the route group. It was never called anywhere.

    // Bug fix: removed unused import Illuminate\Container\Attributes\Auth

    public function addCategoryPage()
    {
        return view('admin.category.add_category');
    }

    public function saveCategory(Request $request)
    {
        $request->validate([
            'cat_name' => 'required|max:100',
        ]);

        $exists = Category::whereRaw('LOWER(cat_name) = ?', [strtolower($request->cat_name)])->first();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', "\"{$request->cat_name}\" category already exists");
        }

        Category::create(['cat_name' => $request->cat_name]);

        return redirect('list_category')->with('success', 'Category added successfully');
    }

    public function listCategory()
    {
        $category = Category::orderBy('cat_name')->paginate(10);
        return view('admin.category.list_category', compact('category'));
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect('list_category')->with('error', 'Category not found');
        }

        $category->delete();

        // Bug fix: with() needs a key-value pair — was with("Category deleted ...") silently
        return redirect('list_category')->with('success', 'Category deleted successfully');
    }

    public function editCategoryPage($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function editCategory(Request $request)
    {
        $request->validate([
            'cat_name' => 'required|max:100',
        ]);

        // Bug fix: exclude the current record from the duplicate check.
        // Without this, editing a category without changing its name returns "already exists".
        $exists = Category::whereRaw('LOWER(cat_name) = ?', [strtolower($request->cat_name)])
            ->where('id', '!=', $request->id)
            ->first();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Another category with this name already exists');
        }

        $category = Category::findOrFail($request->id);
        $category->cat_name = $request->cat_name;
        $category->save();

        return redirect('list_category')->with('success', 'Category updated successfully');
    }
}