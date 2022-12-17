<?php

namespace Tests\Feature\Controllers;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Mockery;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    private User $user;
    private Project $project;
    private Task $task;

    private TaskService $taskService;

    public function setUp(): void
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

        $this->taskService = Mockery::mock(TaskService::class);
    }

    /**
     * タスク一覧画面のテスト
     */
    public function testIndex()
    {
        // 未認証ユーザ
        $response = $this->get(route('task.index', ['projectId' => $this->project->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        
        // サービスモック
        $this->taskService
            ->shouldReceive('getTasks')
            ->once()
            ->with(null, null)
            ->andReturn(Task::all());
        $this->instance(TaskService::class, $this->taskService);

        $response = $this->actingAs($this->user)
            ->get(route('task.index', ['projectId' => $this->project->id]));
        $response->assertStatus(200);
    }

    /**
     * タスク作成画面のテスト
     */
    public function testCreate()
    {
        // 未認証ユーザ
        $response = $this->get(route('task.create', ['projectId' => $this->project->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->get(route('task.create', ['projectId' => $this->project->id]));
        $response->assertStatus(200);
    }

    /**
     * タスク作成のテスト
     */
    public function testStore()
    {
        // 未認証ユーザ
        $response = $this->post(route('task.store', ['projectId' => $this->project->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        // リクエストモック
        $request = Mockery::mock(CreateTaskRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn([]);
        $this->instance(CreateTaskRequest::class, $request);

        // サービスモック
        $this->taskService
            ->shouldReceive('storeTask')
            ->once()
            ->with($this->project->id, [], $this->user->id)
            ->andReturn($this->task);
        $this->instance(TaskService::class, $this->taskService);
        
        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->post(route('task.store', ['projectId' => $this->project->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('task.show', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
    }

    /**
     * タスク詳細画面のテスト
     */
    public function testShow()
    {
        // 未認証ユーザ
        $response = $this->get(route('task.show', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        // サービスモック
        $this->taskService
            ->shouldReceive('getTaskForShow')
            ->once()
            ->with($this->task->id)
            ->andReturn($this->task);
        $this->instance(TaskService::class, $this->taskService);
        
        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->get(route('task.show', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
        $response->assertStatus(200);
    }

    /**
     * タスク編集画面のテスト
     */
    public function testEdit()
    {
        // 未認証ユーザ
        $response = $this->get(route('task.edit', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        // サービスモック
        $this->taskService
            ->shouldReceive('getTaskForEdit')
            ->once()
            ->with($this->task->id)
            ->andReturn($this->task);
        $this->instance(TaskService::class, $this->taskService);
        
        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->get(route('task.edit', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
        $response->assertStatus(200);        
    }

    /**
     * タスク更新のテスト
     */
    public function testUpdate()
    {
        // 未認証ユーザ
        $response = $this->post(route('task.update', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        // リクエストモック
        $request = Mockery::mock(UpdateTaskRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn([]);
        $this->instance(UpdateTaskRequest::class, $request);

        // サービスモック
        $this->taskService
            ->shouldReceive('updateTask')
            ->once()
            ->with($this->project->id, $this->task->id, [], $this->user->id)
            ->andReturn($this->task);
        $this->instance(TaskService::class, $this->taskService);
        
        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->post(route('task.update', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('task.show', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
    }

    /**
     * タスク削除のテスト
     */
    public function testDelete()
    {
        // 未認証ユーザ
        $response = $this->delete(route('task.delete', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        // サービスモック
        $this->taskService
            ->shouldReceive('deleteTask')
            ->once()
            ->with($this->task->id);
        $this->instance(TaskService::class, $this->taskService);
        
        // 認証済みユーザ
        $response = $this->actingAs($this->user)
            ->delete(route('task.delete', ['projectId' => $this->project->id, 'taskId' => $this->task->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('task.index', ['projectId' => $this->project->id]));
    }
}
