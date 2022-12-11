<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\File;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectIds = (Project::factory()->count(5)->create())->pluck('id')->all();
        foreach ($projectIds as $projectId) {
            $userIds = (User::factory()->count(2)->create())->pluck('id')->all();

            foreach ($userIds as $userId) {
                ProjectUser::factory()->create([
                    'project_id' => $projectId,
                    'user_id' => $userId,
                ]);

                $taskIds = (Task::factory()->count(2)->create([
                    'user_id' => $userId,
                    'author_id' => $userId,
                    'project_id' => $projectId,
                ]))->pluck('id')->all();

                foreach ($taskIds as $taskId) {
                    File::factory()->create([
                        'task_id' => $taskId,
                    ]);
                    Comment::factory()->count(2)->create([
                        'user_id' => $userId,
                        'task_id' => $taskId,
                    ]);
                }
            }
        }
    }
}
