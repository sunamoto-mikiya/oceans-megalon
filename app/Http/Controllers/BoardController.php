<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;
use App\Services\BoardService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Board\UpdateTaskStatusRequest;

class BoardController extends Controller
{
    /**
     * すべてのタスク取得
     * @return View
     */
    public function index(int $projectId): View
    {
        $tasks = Task::with(['user', 'comments', 'files'])->where('project_id', $projectId)->get();
        return view('board.index', compact('tasks'));
    }

    /**
     * タスクの状態更新
     * @return RedirectResponse
     * @param UpdateTaskStatusRequest $request
     * @param integer $taskId
     */
    public function update(UpdateTaskStatusRequest $request, BoardService $boardService, int $taskId, int $projectId): RedirectResponse
    {
        $boardService->taskStatusUpdate($taskId, $request->input('status'));
        return to_route('board.index', ['projectId' => $projectId]);
    }
}
