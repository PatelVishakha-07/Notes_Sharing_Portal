<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class CategoryController extends Controller
{
    public function checkAdmin(){
        if(!FacadesAuth::user()){
            return redirect("login");
        }
    }

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

    public function editCategoryPage($id){
        $category = Category::find($id);
        return view("admin.category.edit",compact("category"));
    }
    public function editCategory(Request $request){
        $request->validate([
            "cat_name"=>"required"
        ]);

        $category = Category::find($request->id);
        $category->cat_name = $request->cat_name;
        $category->save();

        return redirect("list_category");
    }
}
