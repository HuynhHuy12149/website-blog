<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable =[
        'post_id',
        'user_id',
        'reply_id',
        'content'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function post(){
        return $this->hasOne(Post::class,'id','post_id');
    }

    public function replies(){
        return $this->hasMany(Comment::class,'reply_id','id');
    }

    public function scopeSearch($query, $term){
        $term = "%$term%";
        $query->where(function($query) use ($term){
            $query->where('content','like',$term);
                  
        });
    }
}
