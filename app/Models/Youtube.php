<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Youtube extends Model
{
    protected $table = "youtube_link";
    protected $fillable = ["notes_id","youtube_link"];

    public function notes(){
        return $this->belongsTo(Notes::class,"notes_id");
    }
}
