<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/',         [HomeController::class, 'home'])->name('home');

Route::get('login',           [AuthController::class, 'loginPage'])->name('login');
Route::get('register',        [AuthController::class, 'registerPage'])->name('register');
Route::post('process_login',  [AuthController::class, 'processLogin'])->name('process_login');
Route::post('process_register', [AuthController::class, 'processRegister'])->name('process_register');


Route::get('/view-file/{file}', function ($file) {

    $path = storage_path('app/public/' . $file);

    if (!file_exists($path)) {
        abort(404);
    }

    $extension = Str::lower(pathinfo($file, PATHINFO_EXTENSION));
    $url       = asset('storage/' . $file);

    if (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
        return redirect('https://view.officeapps.live.com/op/view.aspx?src=' . urlencode($url));
    }

    // PDF / images → open inline
    return response()->file($path);

})->middleware('auth')->name('view_file');


Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('change_password',  [AuthController::class, 'showChangePasswordPage'])->name('change_password');
    Route::post('update_password', [AuthController::class, 'updatePassword'])->name('update_password');

    Route::get('change_name',  [AuthController::class, 'showChangeNamePage'])->name('change_name');
    Route::post('update_name', [AuthController::class, 'updateName'])->name('update_name');

    Route::post('update_profile', [UserController::class, 'updateProfile'])->name('update_profile');
});

//  ADMIN ROUTES

Route::get('admin_dashboard', [AuthController::class, 'adminDashboard'])
    ->middleware('isAdmin')
    ->name('admin_dashboard');

Route::middleware('isAdmin')->group(function () {

    // --- Category ---
    Route::get('add_category',              [CategoryController::class, 'addCategoryPage'])->name('add_category');
    Route::post('save_category',            [CategoryController::class, 'saveCategory'])->name('save_category');
    Route::get('list_category',             [CategoryController::class, 'listCategory'])->name('list_category');
    Route::get('edit_category_page/{id}',   [CategoryController::class, 'editCategoryPage'])->name('edit_category_page');
    Route::post('edit_category',            [CategoryController::class, 'editCategory'])->name('edit_category');

    Route::post('delete_category/{id}',     [CategoryController::class, 'deleteCategory'])->name('delete_category');

    // --- Subject ---
    Route::get('add_subject',               [SubjectController::class, 'addSubjectPage'])->name('add_subject');
    Route::post('save_subject',             [SubjectController::class, 'saveSubject'])->name('save_subject');
    Route::get('list_subject',              [SubjectController::class, 'listSubject'])->name('list_subject');
    Route::get('edit_subject_page/{id}',    [SubjectController::class, 'editSubjectPage'])->name('edit_subject_page');
    Route::post('edit_subject',             [SubjectController::class, 'editSubject'])->name('edit_subject');

    Route::post('delete_subject/{id}',      [SubjectController::class, 'deleteSubject'])->name('delete_subject');

    // --- Admin panel ---
    Route::get('admin/showPendingNotesList',   [AdminController::class, 'showPendingNotesList'])->name('admin.pending_notes');
    Route::get('admin/showUsersList',          [AdminController::class, 'showUserList'])->name('admin.users');

    Route::post('admin/acceptRequest/{val}/{id}', [AdminController::class, 'acceptRequest'])->name('admin.accept_request');

    Route::post('admin/toggle-user-status/{id}', [AdminController::class, 'toggleUserStatus'])->name('admin.toggle_user_status');
});

//  USER ROUTES
Route::get('user_dashboard', [AuthController::class, 'userDashboard'])
    ->middleware('isUser')
    ->name('user_dashboard');

Route::prefix('user')->middleware('isUser')->group(function () {

    Route::get('upload_notes',              [NotesController::class, 'uploadNotePage'])->name('user.upload_notes');
    Route::post('save_notes',              [NotesController::class, 'saveNote'])->name('user.save_notes');
    Route::get('getSubjects/{cat_id}',     [NotesController::class, 'getSubjects'])->name('user.get_subjects');
    Route::get('list_private_notes/{status}', [NotesController::class, 'listNotes'])->name('user.list_private_notes');
    Route::get('list_public_notes/{status}',  [NotesController::class, 'listNotes'])->name('user.list_public_notes');
    Route::get('show_search_notes',        [NotesController::class, 'showSearchPage'])->name('user.search_page');
    Route::post('search_notes',            [NotesController::class, 'searchNotes'])->name('user.search_notes');
    Route::post('access_private_note',     [NotesController::class, 'getPrivateNotes'])->name('user.access_private_note');
    Route::get('all_notes',               [UserController::class, 'publicNotesPage'])->name('user.all_notes');
    Route::post('add_to_fav/{id}',         [UserController::class, 'addToFavourite'])->name('user.add_to_fav');
    Route::get('fav_list',                [UserController::class, 'favouriteList'])->name('user.fav_list');

    Route::post('delete_notes/{id}',       [NotesController::class, 'deleteNote'])->name('user.delete_notes');
});