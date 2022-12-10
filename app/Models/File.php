<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task

class File extends Model
{
    use HasFactory;
    protected $fillable = ['task_id', 'url'];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
