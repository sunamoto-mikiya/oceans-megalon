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

    # Const
    # Status
    public const UNSUPPORTED = 1;
    public const PROCESSING = 2;
    public const ALREADY_PROCESSED = 3;
    public const COMPLETED = 4;
    public const STATUS = [
        self::UNSUPPORTED => '未対応',
        self::PROCESSING => '処理中',
        self::ALREADY_PROCESSED => '処理済み',
        self::COMPLETED => '完了',
    ];

    # Type
    public const TASK = 1;
    public const BUGS = 2;
    public const REQUESTS = 3;
    public const OTHER = 4;
    public const TYPE = [
        self::TASK => 'タスク',
        self::BUGS => 'バグ',
        self::REQUESTS => '要望',
        self::OTHER => 'その他',
    ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function files(){
        return $this->hasMany(File::class);
    }
}
