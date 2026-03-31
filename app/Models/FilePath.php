<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilePath extends Model
{
    protected $table = "file_path";
    protected $fillable = ["file_path","notes_id"];

    public function notes(){
        return $this->belongsTo(Notes::class,"notes_id");
    }
}
