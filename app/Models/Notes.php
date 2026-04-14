<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $table = "notes";
    protected $fillable = ["user_id","cat_id","sub_id","title","visibility", "status", "access_code"];

    public function filePath(){
        return $this->hasMany(FilePath::class,"notes_id");
    }

    public function category(){
        return $this->belongsTo(Category::class,"cat_id");
    }

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }

    public function subject(){
        return $this->belongsTo(Subject::class, "sub_id");
    }

    public function youtubeLink(){
        return $this->hasMany(Youtube::class,"notes_id");
    }
}
