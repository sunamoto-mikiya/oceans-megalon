<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\File;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'author_id',
        'project_id',
        'title',
        'type',
        'status',
        'description',
        'start_date',
        'end_date',
    ];

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

    /**
     * コメント
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 添付ファイル
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * タスク担当者
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * プロジェクト
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * S3にファイル保存
     *
     * @param  int $projectId
     * @param  int $taskId
     * @param  UploadedFile|null $file
     * @return string
     */
    public function putFileS3(int $projectId, int $taskId, UploadedFile|null $file): string
    {
        if (is_null($file)) {
            File::where('task_id', $taskId)->first()?->delete();
            return '';
        }

        // S3にファイル保存
        $path = Storage::disk('s3')->put("/images/projects/{$projectId}/tasks/{$taskId}", $file);
        
        // 既に保存済みならば更新
        $file = File::where('task_id', $taskId)->first();
        $url = Storage::disk('s3')->url($path);
        if (is_null($file)) {
            File::create([
                'task_id' => $taskId,
                'url' => $url,
            ]);
        } else {
            $file->fill([
                'url' => $url,
            ])->saveOrFail();
        }

        return $url;
    }
}
