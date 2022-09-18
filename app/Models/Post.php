<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','user_id','hashtag','created_at','updated_at'];

    public function photos()
    {
       return $this->morphMany(Photo::class,'photoable');
    }

    public function comments()
    {
      return $this->hasMany(Comment::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class,'user_id');
    }

    // Likes
    public function likes(){
        return $this->hasMany(LikeDislike::class,'post_id')->sum('like');
    }
    // Dislikes
    public function dislikes(){
        return $this->hasMany(LikeDislike::class,'post_id')->sum('dislike');
    }
}
