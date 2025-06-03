<?php

namespace Tests\Feature\V1;

use App\Models\TodoTask;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TodoTaskTest extends TestCase
{

    public function test_todo_task_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/v1/todo-tasks', [
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
        $this->actingAs($user);

        $response = $this->getJson('/api/v1/todo-tasks');

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


    public function test_todo_task_update(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = TodoTask::factory()->create([
            'user_id' => $user->id,
            'title' => 'Initial Task',
            'description' => 'This is the initial task description.',
        ]);

        $response = $this->putJson("/api/v1/todo-tasks/{$task->id}", [
            'title' => 'Updated Task',
            'description' => 'This task has been updated.',
            'status' => 'completed',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'title' => 'Updated Task',
                         'description' => 'This task has been updated.',
                         'dueDate' => '2025-12-31T23:59:59',
                         'status' => 'completed',
                     ],
                 ]);
    }

    /*
    public function test_todo_task_delete(): void
    {
        $task = TodoTask::factory()->create();

        $response = $this->deleteJson("/api/v1/todo-tasks/{$task->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('todo_tasks', ['id' => $task->id]);
    } */
}
