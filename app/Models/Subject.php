<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = "subject";
    protected $fillable = ["sub_name", "cat_id"];

    public function category(){
        return $this->belongsTo(Category::class,"cat_id");
    }
}
