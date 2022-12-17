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
     * @param  int $userId
     * @return Collection
     */
    public function getProjects(int $userId): Collection
    {
        $user = User::findOrFail($userId);
        $projects = $user->projects;

        return $projects;
    }

    /**
     * projectの作成
     *
     * @param  string $title
     * @param  string $description
     * @param  array $userIds
     * @return Project
     */
    public function storeProject(string $title, string $description, array $userIds): Project
    {
        $project = new Project();
        $project->fill([
            'title' => $title,
            'description' => $description,
        ])->save();

        $project->users()->sync($userIds);

        return $project;
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
