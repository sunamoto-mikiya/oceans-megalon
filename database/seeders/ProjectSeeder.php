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
        $oceans = User::factory()->create([
            'name' => 'オーシャンズ',
            'email' => 'oceans@example.com',
        ]);
        $projectIds = (Project::factory()->count(5)->create())->pluck('id')->all();
        foreach ($projectIds as $projectId) {
            ProjectUser::factory()->create([
                'project_id' => $projectId,
                'user_id' => $oceans->id,
            ]);

            $users = User::factory()->count(4)->create();
            foreach ($users as $user) {
                ProjectUser::factory()->create([
                    'project_id' => $projectId,
                    'user_id' => $user->id,
                ]);

                $task1 = Task::factory()->create([
                    'user_id' => $oceans->id,
                    'author_id' => $user->id,
                    'project_id' => $projectId,
                    'title' => "{$oceans->name}の課題",
                    'type' => array_rand(Task::TYPE),
                    'status' => array_rand(Task::STATUS),
                    'description' => "{$oceans->name}の課題です",
                ]);
                $task2 = Task::factory()->create([
                    'user_id' => $user->id,
                    'author_id' => $oceans->id,
                    'project_id' => $projectId,
                    'title' => "{$user->name}の課題",
                    'type' => array_rand(Task::TYPE),
                    'status' => array_rand(Task::STATUS),
                    'description' => "{$user->name}の課題です",
                ]);

                Comment::factory()->create([
                    'user_id' => $oceans->id,
                    'task_id' => $task1->id,
                ]);
                Comment::factory()->create([
                    'user_id' => $user->id,
                    'task_id' => $task1->id,
                ]);

                Comment::factory()->create([
                    'user_id' => $user->id,
                    'task_id' => $task2->id,
                ]);
                Comment::factory()->create([
                    'user_id' => $oceans->id,
                    'task_id' => $task2->id,
                ]);
            }
        }
    }
}
