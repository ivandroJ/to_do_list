<?php

namespace Tests\Feature\V1;

use App\Models\TodoTask;
use App\Models\User;
use App\TodoTaskStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TodoTaskTest extends TestCase
{

    public function test_todo_task_create()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/todo-tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'Test Task',
                    'description' => 'This is a test task.',
                    'status' => 'Pendente',
                ],
            ]);
    }
    public function test_todo_task_index()
    {
        $user = User::factory()
            ->has(TodoTask::factory()->count(5))
            ->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response =  $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/todo-tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'status',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function test_todo_task_index_with_status_filter()
    {
        $user = User::factory()
            ->has(TodoTask::factory()->count(5)->state(['status' => TodoTaskStatusEnum::COMPLETED->label()]))
            ->has(TodoTask::factory()->count(5)->state(['status' => TodoTaskStatusEnum::PENDING->label()]))
            ->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response =  $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/todo-tasks?by_status=' . TodoTaskStatusEnum::COMPLETED->label());

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => TodoTaskStatusEnum::COMPLETED->label(),
            ])
            ->assertJsonCount(5, 'data');
    }


    public function test_todo_task_update(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $task = TodoTask::factory()->create([
            'user_id' => $user->id,
            'title' => 'Initial Task',
            'description' => 'This is the initial task description.',
            'status' => TodoTaskStatusEnum::PENDING->label(),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/v1/todo-tasks/{$task->id}", [
                'status' => TodoTaskStatusEnum::IN_PROGRESS->label(),
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'status' => TodoTaskStatusEnum::IN_PROGRESS->label(),
                ],
            ]);

        // Verify the task was updated in the database
        $this->assertDatabaseHas('todo_tasks', [
            'id' => $task->id,
            'status' => TodoTaskStatusEnum::IN_PROGRESS->label(),
        ]);


        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/v1/todo-tasks/{$task->id}", [
                'status' => TodoTaskStatusEnum::COMPLETED->label(),
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'status' => TodoTaskStatusEnum::COMPLETED->label(),
                ],
            ]);

        // Verify the task was updated in the database
        $this->assertDatabaseHas('todo_tasks', [
            'id' => $task->id,
            'status' => TodoTaskStatusEnum::COMPLETED->label(),
        ]);
    }


    public function test_todo_task_delete(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $task = TodoTask::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/v1/todo-tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('todo_tasks', ['id' => $task->id]);
    }
}
