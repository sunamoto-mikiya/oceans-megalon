<?php

namespace Tests\Feature\Services;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\BoardService;
use Mockery;

class BoardServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Task $task;
    private Project $project;

    private BoardService $boardService;

    public function setUp(): void
    {
        parent::setUp();
        $this->user=User::factory()->create();
        $this->project=Project::factory()->create();
        $this->task = Task::factory()->create([
            'user_id' => $this->user->id,
            'author_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status' => Task::UNSUPPORTED,
        ]);

        $this->boardService = new BoardService();
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function ステータスの更新()
    {
        $task = $this->boardService->taskStatusUpdate($this->task->id, Task::PROCESSING);

        $this->assertEquals(Task::PROCESSING, $task->status);
    }
}
