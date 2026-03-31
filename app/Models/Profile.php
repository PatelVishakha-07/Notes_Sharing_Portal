<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "user_profile";
    protected $fillable = ["profile_pic","user_id", "bio"];
}
