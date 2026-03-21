<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

//Category
Route::get("add_category",[CategoryController::class,"addCategoryPage"]);
Route::post("save_category",[CategoryController::class,"saveCategory"]);
Route::get("list_category",[CategoryController::class,"listCategory"]);
Route::get("delete_category/{id}",[CategoryController::class,"deleteCategory"]);

//Subject
Route::get("add_subject",[SubjectController::class,"addSubjectPage"]);
Route::post("save_subject",[SubjectController::class,"saveSubject"]);
Route::get("list_subject",[SubjectController::class,"listSubject"]);
Route::get("delete_subject/{id}",[SubjectController::class,"deleteSubject"]);


Route::get('/', function () {
    return view('welcome');
});
