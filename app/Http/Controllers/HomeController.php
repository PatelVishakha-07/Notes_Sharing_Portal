<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
           
        $notes = Notes::with(['filePath', 'subject', 'category'])->has('filePath') 
                ->where("visibility", "Public")->where("status","Approved")->latest()->get();
        return view("welcome", compact("notes"));
    }
}
