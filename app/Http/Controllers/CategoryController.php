<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategoryPage(){
        return view("admin.category.add_category");
    }

    public function saveCategory(Request $request){
        $request->validate([
            "cat_name"=>"required"
        ]);

        Category::create([
            "cat_name"=>$request->cat_name
        ]);

        return redirect("list_category");
    }

    public function listCategory(){
        $category = Category::get();
        return view("admin.category.list_category",compact("category"));
    }

    public function deleteCategory($id){
        Category::find($id)->delete();
        return redirect("list_category")->with("Category deleted successfully");
    }
}
