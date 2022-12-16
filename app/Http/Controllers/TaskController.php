<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Project;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * タスク一覧
     *
     * @param  Request $request
     * @param  int $projectId
     * @return View
     */
    public function index(Request $request, TaskService $taskService, int $projectid): View
    {
        // クエリに基づいて，タスク一覧の取得
        $tasks = $taskService->getTasks($request->input('status'), $request->input('user_id'));
        return view('task.index', compact('tasks'));
    }

    /**
     * タスク作成画面
     *
     * @param  int $projectId
     * @return View
     */
    public function create(int $projectId): View
    {
        // タスクにかかわるユーザ設定のため，プロジェクト関係User取得
        $projectUsers = Project::findOrFail($projectId)->users;
        return view('task.create', compact('projectUsers'));
    }

    /**
     * タスク作成
     *
     * @param  CreateTaskRequest $request
     * @param  int $projectId
     * @return RedirectResponse
     */
    public function store(CreateTaskRequest $request, TaskService $taskService, int $projectId): RedirectResponse
    {
        // 入力内容をもとに，Task，File追加
        $task = $taskService->storeTask($projectId, $request->validated(), Auth::id());
        return Redirect::route('task.show', [$projectId, $task->id]);
    }

    /**
     * タスク詳細
     *
     * @param  int $projectId
     * @param  int $taskId
     * @return View
     */
    public function show(TaskService $taskService, int $projectId, int $taskId): View
    {
        // Task, Files，Comments取得
        $task = $taskService->getTaskForShow($taskId);
        return view('task.show', compact('task'));
    }

    /**
     * タスク編集画面
     *
     * @param  int $projectId
     * @param  int $taskId
     * @return View
     */
    public function edit(TaskService $taskService, int $projectId, int $taskId): View
    {
        // Task, Files, Comments, ProjectUsers取得
        $task = $taskService->getTaskForEdit($projectId, $taskId);
        return view('task.edit', compact('task'));
    }

    /**
     * タスク更新
     *
     * @param  CreateTaskRequest $request
     * @param  int $projectId
     * @param  int $taskId
     * @return RedirectResponse
     */
    public function update(UpdateTaskRequest $request, TaskService $taskService, int $projectId, int $taskId): RedirectResponse
    {
        // 入力内容をもとに，Task，File更新
        $task = $taskService->updateTask($projectId, $taskId, $request->validated(), Auth::id());
        return Redirect::route('task.show', [$projectId, $taskId]);
    }

    /**
     * タスク削除
     *
     * @param  int $projectId
     * @param  int $taskId
     * @return RedirectResponse
     */
    public function delete(TaskService $taskService, int $projectId, int $taskId): RedirectResponse
    {
        // Task，Files, Comments削除
        $taskService->deleteTask($taskId);
        return Redirect::route('task.index', [$projectId]);
    }
}
