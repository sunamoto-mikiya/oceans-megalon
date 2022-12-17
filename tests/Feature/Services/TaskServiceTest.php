<?php

namespace Tests\Feature\Services;

use App\Models\Comment;
use App\Models\File;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Carbon\CarbonImmutable;
use Hamcrest\Matchers;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    private User $user;
    private Project $project;
    private Task $task;
    private Task $taskMock;
    
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
            'status' => Task::UNSUPPORTED,
        ]);

        $this->taskMock = Mockery::mock(Task::class);
        $this->taskService = new TaskService($this->taskMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * タスク一覧の取得のテスト
     */
    public function testGetTasks()
    {
        $user2 = User::factory()->create();
        $task2 = Task::factory()->create([
            'user_id' => $user2->id,
            'author_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status' => Task::COMPLETED,
        ]);

        // statusとuser_idのどちらも指定しない
        $tasks = $this->taskService->getTasks(null, null, $this->project->id);
        foreach ([$this->task->id, $task2->id] as $taskId) {
            $this->assertContains($taskId, $tasks->pluck('id')->all());
        }

        // statusのみ指定
        $tasks = $this->taskService->getTasks(Task::COMPLETED, null, $this->project->id);
        $this->assertContains($task2->id, $tasks->pluck('id')->all());

        // user_idのみ指定
        $tasks = $this->taskService->getTasks(null, $user2->id, $this->project->id);
        $this->assertContains($task2->id, $tasks->pluck('id')->all());

        // statusとuser_idの両方指定
        $tasks = $this->taskService->getTasks(Task::UNSUPPORTED, $this->user->id, $this->project->id);
        $this->assertContains($this->task->id, $tasks->pluck('id')->all());
    }

    /**
     * タスク作成のテスト
     */
    public function testStoreTask()
    {
        $start_date = CarbonImmutable::now();
        $end_date = CarbonImmutable::now()->addDays(3);
        $fakeImage = UploadedFile::fake()->image('fake.png');
        $params = [
            'user_id' => $this->user->id,
            'title' => 'title',
            'type' => Task::TASK,
            'status' => Task::UNSUPPORTED,
            'description' => 'description',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'file' => $fakeImage,
        ];

        // TestModelモック
        $this->taskMock
            ->shouldReceive('putFileS3')
            ->once()
            ->with($this->project->id, $this->task->id+1, Matchers::equalTo($fakeImage))
            ->andReturn('filePath');
        $this->instance(Task::class, $this->taskMock);

        $task = $this->taskService->storeTask($this->project->id, $params, $this->user->id);

        $this->assertEquals($this->project->id, $task->project_id);
        $this->assertEquals($params['user_id'], $task->user_id);
        $this->assertEquals($params['title'], $task->title);
        $this->assertEquals($params['type'], $task->type);
        $this->assertEquals($params['status'], $task->status);
        $this->assertEquals($params['description'], $task->description);
        $this->assertEquals($params['start_date'], $task->start_date);
        $this->assertEquals($params['end_date'], $task->end_date);
    }

    /**
     * 詳細画面用タスク取得のテスト
     */
    public function testGetTaskForShow()
    {
        $file = File::factory()->create([
            'task_id' => $this->task->id,
        ]);
        $comment = Comment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id,
        ]);

        $task = $this->taskService->getTaskForShow($this->task->id);
        $this->assertEquals($this->task->user_id, $task->user_id);
        $this->assertEquals($this->task->title, $task->title);
        $this->assertEquals($this->task->description, $task->description);
        $this->assertEquals($this->task->start_date, $task->start_date);
        $this->assertEqualsCanonicalizing($this->task->comments->pluck('id')->all(), [$comment->id]);
        $this->assertEqualsCanonicalizing($this->task->files->pluck('id')->all(), [$file->id]);
    }

    /**
     * 編集画面用タスク取得のテスト
     */
    public function testGetTaskForEdit()
    {
        $file = File::factory()->create([
            'task_id' => $this->task->id,
        ]);
        $comment = Comment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id,
        ]);

        $task = $this->taskService->getTaskForEdit($this->task->id);
        $this->assertEquals($this->task->user_id, $task->user_id);
        $this->assertEquals($this->task->title, $task->title);
        $this->assertEquals($this->task->description, $task->description);
        $this->assertEquals($this->task->start_date, $task->start_date);
        $this->assertEqualsCanonicalizing($this->task->comments->pluck('id')->all(), [$comment->id]);
        $this->assertEqualsCanonicalizing($this->task->files->pluck('id')->all(), [$file->id]);
        $this->assertEqualsCanonicalizing($this->task->project->users->pluck('id')->all(), [$this->user->id]);
    }

    /**
     * タスク更新のテスト
     */
    public function testUpdateTask()
    {
        $start_date = CarbonImmutable::now();
        $end_date = CarbonImmutable::now()->addDays(3);
        $fakeImage = UploadedFile::fake()->image('fake.png');
        $params = [
            'user_id' => $this->user->id,
            'title' => 'title',
            'type' => Task::TASK,
            'status' => Task::UNSUPPORTED,
            'description' => 'description',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'file' => $fakeImage,
        ];

        // TestModelモック
        $this->taskMock
            ->shouldReceive('putFileS3')
            ->once()
            ->with($this->project->id, $this->task->id, Matchers::equalTo($fakeImage))
            ->andReturn('filePath');
        $this->instance(Task::class, $this->taskMock);

        $task = $this->taskService->updateTask($this->project->id, $this->task->id, $params, $this->user->id);

        $this->assertEquals($this->project->id, $task->project_id);
        $this->assertEquals($params['user_id'], $task->user_id);
        $this->assertEquals($params['title'], $task->title);
        $this->assertEquals($params['type'], $task->type);
        $this->assertEquals($params['status'], $task->status);
        $this->assertEquals($params['description'], $task->description);
        $this->assertEquals($params['start_date'], $task->start_date);
        $this->assertEquals($params['end_date'], $task->end_date);
    }

    /**
     * Task削除のテスト
     */
    public function testDeleteTask()
    {
        $file = File::factory()->create([
            'task_id' => $this->task->id,
        ]);
        $comment = Comment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id,
        ]);

        $this->taskService->deleteTask($this->task->id);

        $this->assertModelMissing($this->task);
        $this->assertModelMissing($file);
        $this->assertModelMissing($comment);
    }
}
