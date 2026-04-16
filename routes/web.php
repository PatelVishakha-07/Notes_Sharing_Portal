<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Logout
Route::get("logout",[AuthController::class,"logout"]);

//Admin
Route::get("admin_dashboard",[AuthController::class,"adminDashboard"])->middleware("isAdmin");

//User
Route::get("user_dashboard",[AuthController::class,"userDashboard"]);

Route::prefix("user")->group(function(){
    Route::get("/upload_notes",[NotesController::class,"uploadNotePage"]);
    Route::post("/save_notes",[NotesController::class,"saveNote"]);
    Route::get("/getSubjects/{cat_id}",[NotesController::class,"getSubjects"]);
    Route::get("/list_private_notes/{status}",[NotesController::class,"listNotes"]);
    Route::get("/list_public_notes/{status}",[NotesController::class,"listNotes"]);
    Route::get("/delete_notes/{id}",[NotesController::class,"deleteNote"]);
    Route::get("/show_search_notes",[NotesController::class,"showSearchPage"]);
    Route::post("/search_notes",[NotesController::class,"searchNotes"]);
    Route::post("/access_private_note",[NotesController::class,"getPrivateNotes"]);
    Route::get("all_notes",[UserController::class,"publicNotesPage"]);

    Route::post("add_to_fav/{id}",[UserController::class, "addToFavourite"]);

    Route::get("fav_list",[UserController::class, "favouriteList"]);
});




    //Authentication
    Route::get("login",[AuthController::class,"loginPage"]);
    Route::post("process_login",[AuthController::class,"processLogin"]);
    Route::get("register",[AuthController::class,"registerPage"]);
    Route::post("process_register",[AuthController::class,"processRegister"]);



Route::middleware(["isAdmin"])->group(function(){
    //Category
    Route::get("add_category",[CategoryController::class,"addCategoryPage"]);
    Route::post("save_category",[CategoryController::class,"saveCategory"]);
    Route::get("list_category",[CategoryController::class,"listCategory"]);
    Route::get("edit_category_page/{id}",[CategoryController::class,"editCategoryPage"]);
    Route::post("edit_category",[CategoryController::class,"editCategory"]);
    Route::get("delete_category/{id}",[CategoryController::class,"deleteCategory"]);

    //Subject
    Route::get("add_subject",[SubjectController::class,"addSubjectPage"]);
    Route::post("save_subject",[SubjectController::class,"saveSubject"]);
    Route::get("list_subject",[SubjectController::class,"listSubject"]);
    Route::get("edit_subject_page/{id}",[SubjectController::class,"editSubjectPage"]);
    Route::post("edit_subject",[SubjectController::class,"editSubject"]);
    Route::get("delete_subject/{id}",[SubjectController::class,"deleteSubject"]);

    Route::get("admin/acceptRequest/{val}/{id}",[AdminController::class,"acceptRequest"]);
    Route::get("admin/showPendingNotesList",[AdminController::class, "showPendingNotesList"]);

    Route::get("admin/showUsersList",[AdminController::class, "showUserList"]);

});


Route::get('/', [HomeController::class, "home"]);
Route::get('home/note/view/{id}', [HomeController::class, "viewHomeNote"])->middleware("auth");


Route::get('/view-file/{file}', function ($file) {

    $path = storage_path('app/public/' . $file);

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="'.$file.'"'
    ]);
});

