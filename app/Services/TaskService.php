<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    private Task $task;

    public function __construct(Task $task = null)
    {
        $this->task = $task ?? new Task();
    }

    /**
     * タスク一覧取得（Status，担当者で検索）
     *
     * @param  array $params
     * @return Collection
     */
    public function getTasks(int $status = null, int $userId = null): Collection
    {
        $query = Task::query();

        // Statusで絞込
        if (!is_null($status)) {
            $query->where('status', $status);
        }

        // 担当者で絞込
        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }

        return $query->get();
    }

    /**
     * タスク作成
     *
     * @param  int $projectId
     * @param  array $params
     * @return Task
     */
    public function storeTask(int $projectId, array $params, int $authorId): Task
    {
        $file = $params['file'];
        unset($params['file']);

        // タスク作成
        $params['project_id'] = $projectId;
        $params['author_id'] = $authorId;
        $task = Task::create($params);

        // 画像ファイルS3アップロード
        $this->task->putFileS3($projectId, $task->id, $file);

        return $task;
    }

    /**
     * 詳細画面用タスク取得
     *
     * @param  int $taskId
     * @return Task
     */
    public function getTaskForShow(int $taskId): Task
    {
        // 添付ファイルとコメントを取得
        $task = Task::query()->with([
            'user',
            'files',
            'comments',
        ])->findOrFail($taskId);

        return $task;
    }

    /**
     * 編集画面用タスク取得
     *
     * @param  int $projectId
     * @return Task
     */
    public function getTaskForEdit(int $taskId): Task
    {
        // 添付ファイル，コメント，プロジェクト関係ユーザを取得
        $task = Task::query()->with([
            'user',
            'files',
            'comments',
            'project.users',
        ])->findOrFail($taskId);

        return $task;
    }

    /**
     * タスク更新
     *
     * @param  int $projectId
     * @param  int $taskId
     * @param  array $params
     * @return Task
     */
    public function updateTask(int $projectId, int $taskId, array $params, int $authorId): Task
    {
        $file = $params['file'];
        unset($params['file']);

        // タスク更新
        $params['author_id'] = $authorId;
        $task = Task::findOrFail($taskId);
        $task->fill($params);
        $task->saveOrFail();

        // 画像ファイルS3アップロード
        $this->task->putFileS3($projectId, $task->id, $file);

        return $task;
    }

    /**
     * タスク削除
     *
     * @param  int $taskId
     * @return void
     */
    public function deleteTask(int $taskId): void
    {
        $task = Task::findOrFail($taskId);
        $task->delete();
    }
}
