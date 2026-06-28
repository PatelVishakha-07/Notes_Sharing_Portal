<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {        
        $notes = Notes::with(['filePath', 'subject', 'category', 'user'])
            ->where('visibility', 'Public')
            ->where('status', 'Approved')
            ->latest()
            ->paginate(20);

        return view('welcome', compact('notes'));
    }
}