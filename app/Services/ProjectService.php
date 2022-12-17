<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    private Project $task;

    public function __construct(Project $task = null)
    {
        $this->task = $task ?? new Project();
    }

    public function getProjects($userId): Collection
    {
        $query = Project::query()->where('user_id', $userId);

        return $query->get();
    }
}
