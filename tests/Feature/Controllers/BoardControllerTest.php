<?php

namespace Tests\Feature\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\BoardService;

class BoardControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Task $task;
    private Project $project;

    private BoardService $boardService;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->project = Project::factory()->create();
        $this->task = Task::factory()->create([
            'user_id' => $this->user->id,
            'author_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status' => Task::UNSUPPORTED,
        ]);

        $this->boardService = Mockery::mock(BoardService::class);
    }

    /**
     * @test
     */
    public function 全タスク取得()
    {
        // 未認証ユーザー
        $response = $this->get(route('board.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        //認証ユーザー
        $response = $this->actingAs($this->user)->get(route('board.index', ['projectId' => $this->project->id]));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function ステータス更新とボードのタスク一覧へ遷移()
    {
        // 未認証ユーザー
        $response = $this->get(route('board.update', [
            'taskId' => $this->task->id,
            'status' => Task::PROCESSING,
            'projectId' => $this->project->id,
        ]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        //サービスモック
        $this->boardService
            ->shouldReceive('taskStatusUpdate')
            ->once()
            ->with($this->task->id, Task::PROCESSING);
        $this->instance(BoardService::class, $this->boardMock);

        //認証ユーザー
        $response = $this->actingAs($this->user)->post(route('board.update', [
            'taskId' => $this->task->id,
            'projectId' => $this->project->id
        ]));
        $response->assertRedirect(route('board.index', ['projectId' => $this->project->id]));
        $response->assertStatus(200);
    }
}
