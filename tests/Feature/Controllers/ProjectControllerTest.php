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
use Hamcrest\Matchers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
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

        $this->projectService = Mockery::mock(ProjectService::class);
    }

    /**
     * @test
     */
    public function プロジェクト一覧画面へのアクセス()
    {
        // 未認証ユーザ
        $response = $this->get(route('project.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        
        // サービスモック
        $this->projectService
            ->shouldReceive('getProjects')
            ->once()
            ->with($this->user->id)
            ->andReturn(Project::all());
        $this->instance(ProjectService::class, $this->projectService);

        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->get(route('project.index'));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function プロジェクト作成画面へのアクセス()
    {
        // 未認証ユーザ
        $response = $this->get(route('project.create'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->get(route('project.create'));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function プロジェクト作成()
    {
        // 未認証ユーザ
        $response = $this->post(route('project.store'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        // リクエストモック
        $request = Mockery::mock(Request::class);
        $request
            ->shouldReceive('input')
            ->with('title')
            ->andReturn('title');
        $request
            ->shouldReceive('input')
            ->with('description')
            ->andReturn('description');
        $request
            ->shouldReceive('input')
            ->with('users')
            ->andReturn([]);
        $this->instance(Request::class, $request);
        
        // サービスモック
        $this->projectService
            ->shouldReceive('storeProject')
            ->once()
            ->with('title', 'description', [])
            ->andReturn($this->project);
        $this->instance(ProjectService::class, $this->projectService);
        
        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->post(route('project.store'));
        $response->assertStatus(302);
        $response->assertRedirect(route('project.index'));
    }

    // /**
    //  * @test
    //  */
    // public function プロジェクト詳細画面へのアクセス()
    // {
    //     // 未認証ユーザ
    //     $response = $this->get(route('project.index'));
    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('login'));
    // }

    /**
     * @test
     */
    // public function プロジェクト編集画面へのアクセス()
    // {
    //     // 未認証ユーザ
    //     $response = $this->get(route('project.edit'));
    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('login'));
        
    //     // サービスモック
    //     $this->projectService
    //         ->shouldReceive('getProjectForEdit')
    //         ->once()
    //         ->with()
    //         ->andReturn($this->project);
    //     $this->instance(ProjectService::class, $this->projectService);
        
    //     // 認証済みユーザ
    //     $response = $this->actingAs($this->user)
    //         ->get(route('project.edit', ['projectId' => $this->project->id]));
    //     $response->assertStatus(200);
    // }

    /**
     * @test
     */
    // public function プロジェクト更新処理()
    // {
    //     // 未認証ユーザ
    //     $response = $this->get(route('project.update'));
    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('login'));
        
    //     // サービスモック
    //     $this->projectService
    //         ->shouldReceive('updateProject')
    //         ->once()
    //         ->with()
    //         ->andReturn($this->project);
    //     $this->instance(ProjectService::class, $this->projectService);
        
    //     // 認証済みユーザ
    //     $response = $this->actingAs($this->user)
    //         ->post(route('project.update', ['projectId' => $this->project->id]));
    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('project.show', ['projectId' => $this->project->id]));
    // }

    /**
     * @test
     */
    public function プロジェクト削除()
    {
        // 未認証ユーザ
        $response = $this->delete(route('project.delete', ['projectId' => $this->project->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        
        // サービスモック
        $this->projectService
            ->shouldReceive('deleteProject')
            ->once()
            ->with($this->project->id);
        $this->instance(ProjectService::class, $this->projectService);
        
        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->delete(route('project.delete', ['projectId' => $this->project->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('project.index'));
    }
}
