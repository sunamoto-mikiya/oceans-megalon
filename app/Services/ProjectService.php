<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;

class ProjectService
{
    private Project $task;

    public function __construct(Project $task = null)
    {
        $this->task = $task ?? new Project();
    }

    /**
     * ユーザーに紐づくプロジェクト一覧取得
     *
     * @param  array $params
     * @return Collection
     */
    public function getProjects(): Collection
    {
        $userInfo = Auth::user();
        $user = User::findOrFail($userInfo->id);
        $projects = $user->projects;

        return $projects;
    }

    /**
     * projectの作成
     *
     * @param  array $params
     */
    public function storeProject($request)
    {
        $project = new Project();
        $project->fill(['title' => $request->title, 'description' => $request->description])->save();

        $project->users()->sync($request->users);
    }


    /**
     * projectの削除
     *
     * @param  array $params
     */
    public function deleteProject($projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->delete();
    }
}
