<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table = "favourite";
    protected $fillable = ["user_id","notes_id"];
}
