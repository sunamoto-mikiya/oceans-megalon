<?php

namespace App\Services;

use App\Models\Task;

class BoardService
{
    /**
     * タスクのステータス更新
     * @param integer $taskId
     * @param integer $status
     * @return Task
     */
    public function taskStatusUpdate(int $taskId, int $status): Task
    {
        $task = Task::findOrFail($taskId);
        $task->fill(['status' => $status]);
        $task->saveOrFail();
        return $task;
    }
}
