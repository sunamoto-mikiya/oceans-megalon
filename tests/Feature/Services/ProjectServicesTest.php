<?php

namespace Tests\Feature\Services;

use App\Models\Comment;
use App\Models\File;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use App\Services\ProjectService;
use App\Services\TaskService;
use Carbon\CarbonImmutable;
use Hamcrest\Matchers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class ProjectServicesTest extends TestCase
{
    private User $user;
    private Project $project;
    private ProjectUser $projectUser;
    private Task $task;
    private Task $taskMock;
    
    private ProjectService $projectService;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->project = Project::factory()->create();
        $this->projectUser = ProjectUser::factory()->create([
            'project_id' => $this->project->id,
            'user_id' => $this->user->id,
        ]);
        // $this->task = Task::factory()->create([
        //     'user_id' => $this->user->id,
        //     'author_id' => $this->user->id,
        //     'project_id' => $this->project->id,
        //     'status' => Task::UNSUPPORTED,
        // ]);

        // $this->taskMock = Mockery::mock(Task::class);
        $this->projectService = new ProjectService();
    }

    /**
     * プロジェクト一覧取得
     */
    public function プロジェクト一覧取得()
    {
        $project2 = Project::factory()->create();
        ProjectUser::factory()->create([
            'project_id' => $project2->id,
            'user_id' => $this->user->id,
        ]);
        $projects = $this->projectService->getProjects($this->user->id);

        foreach ($projects->pluck('id')->all() as $projectId) {
            $this->assertContains($projectId, [$this->project->id, $project2->id]);
        }
    }

    /**
     * プロジェクト作成処理
     */
    public function プロジェクト作成処理()
    {
        $title = 'test title';
        $description = 'description';
        $user = User::factory()->create();

        $project = $this->projectService->storeProject($title, $description, new Collection([$user]));

        $this->assertEquals($title, $project->title);
        $this->assertEquals($description, $project->description);
        $this->assertEqualsCanonicalizing([$user->id], $project->users->pluck('id')->all());
    }

    /**
     * 編集するプロジェクトの取得
     */
    public function 編集するプロジェクトの取得()
    {
        $project = $this->projectService->getProjectForEdit($this->project->id);

        $this->assertEquals($this->project->title, $project->title);
        $this->assertEquals($this->project->description, $project->description);
    }

    /**
     * プロジェクト更新処理のテスト
     */
    public function プロジェクト更新処理のテスト()
    {
        $params = [
            'title' => 'test updated title',
            'description' => 'test updated description',
        ];

        $project = $this->projectService->updateProject($params);
        $this->assertEquals($params['title'], $project->title);
        $this->assertEquals($params['description'], $project->description);
    }

    /**
     * プロジェクト削除処理のテスト
     */
    public function プロジェクト削除処理のテスト()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'author_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status' => Task::UNSUPPORTED,
        ]);

        $this->projectService->deleteProject($this->project->id);

        $this->assertModelMissing($this->project);
        $this->assertModelMissing($this->projectUser);
        $this->assertModelMissing($task);
    }
}
