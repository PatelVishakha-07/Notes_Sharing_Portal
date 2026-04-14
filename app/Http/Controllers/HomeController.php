<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        //$notes = Notes::with("filePath")->where("visibility","Public")->get();    
           
        $notes = Notes::with(['filePath', 'subject', 'category'])
                ->has('filePath') // ONLY get notes that have at least one file
                ->where("visibility", "Public")
                ->latest()
                ->get();
        return view("welcome", compact("notes"));
    }
}
