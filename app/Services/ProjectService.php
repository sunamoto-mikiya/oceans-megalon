<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProjectService
{
    private Project $task;

    public function __construct(Project $task = null)
    {
        $this->task = $task ?? new Project();
    }

    public function getProjects(): Collection
    {
        $userInfo = Auth::user();
        $user = User::findOrFail($userInfo->id);
        $projects = $user->projects;

        return $projects;
    }
}
