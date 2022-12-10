<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\File;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'author_id', 'project_id', 'title','type','status','description','start_date','end_date'];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function files(){
        return $this->hasMany(File::class);
    }
}
