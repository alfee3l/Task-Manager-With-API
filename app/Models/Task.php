<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Task extends Model
{
    use HasApiTokens;
    protected $fillable=['title','description','priority','user_id'];

    Public function user(){
        return $this->belongsTo(User::class);
    }
    Public function categories(){
        return $this->belongsToMany(Category::class,'category_task');
    }

    public function favoriteByUser(){
        return $this->belongsToMany(User::class,'favorites');
    }
}
