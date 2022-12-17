<?php

namespace Tests\Unit\Models;

use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TaskTest extends TestCase
{
    private User $user;
    private Project $project;
    private Task $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->project = Project::factory()->create();
        $this->task = Task::factory()->create([
            'user_id' => $this->user->id,
            'author_id' => $this->user->id,
            'project_id' => $this->project->id,
        ]);
    }

    /**
     * S3にファイル保存のテスト
     */
    public function testPutFileS3()
    {
        Storage::fake('s3');

        $fakeImage = UploadedFile::fake()->image('fake.png');
        
        $url = $this->task->putFileS3($this->project->id, $this->task->id, $fakeImage);
        // Storage::disk('s3')->assertExists($url);

        $file = File::where('task_id', $this->task->id)->first();
        $this->assertEquals($url, $file->url);
    }

    /**
     * タスク更新時に，ファイルがNULLの時のテスト
     */
    // public function testDeleteFileS3()
    // {
    //     Storage::fake('s3');

    //     $file = File::factory()->create([
    //         'task_id' => $this->task->id,
    //     ]);

    //     $this->task->putFileS3($this->project->id, $this->task->id, null);
        
    //     $this->assertModelMissing($file);
    // }
}
