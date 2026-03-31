<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";
    protected $fillable = ["cat_name"];

    public function subject(){
        return $this->hasMany(Subject::class,"cat_id");
    }

    public function notes(){
        return $this->hasMany(Notes::class, "cat_id");
    }
}
