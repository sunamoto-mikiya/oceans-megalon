<?php

namespace Tests\Feature\Controllers;

use App\Models\ProjectUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Services\ProjectService;
use App\Models\Project;
use Mockery;

class ProjectControllerTest extends TestCase
{
    private User $user;
    private ProjectUser $project_user;
    private Task $task;
    private Project $project;

    private ProjectService $projectService;

    public function setUp():void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create();
        ProjectUser::factory()->create([
            'project_id' => $this->project->id,
            'user_id' => $this->user->id,
        ]);
        $this->task = Task::factory()->create([
            'user_id' => $this->user->id,
            'author_id' => $this->user->id,
            'project_id' => $this->project->id,
        ]);

        $this->projectService = Mockery::mock(Projectervice::class);

    }

    /**
     * @test
     */
    public function プロジェクト一覧画面へのアクセス()
    {
    }

    /**
     * @test
     */
    public function プロジェクト作成()
    {
    }

    /**
     * @test
     */
    public function プロジェクト作成画面へのアクセス()
    {
    }

    /**
     * @test
     */
    public function プロジェクト詳細画面へのアクセス()
    {
    }

    /**
     * @test
     */
    public function プロジェクト編集画面へのアクセス()
    {
    }

    /**
     * @test
     */
    public function プロジェクト更新処理()
    {
    }

    /**
     * @test
     */
    public function プロジェクト削除()
    {
    }
}
