<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table = "favourite";
    protected $fillable = ["user_id","notes_id"];

    public function notes(){
        return $this->belongsTo(Notes::class,"notes_id");
    }

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }
}
