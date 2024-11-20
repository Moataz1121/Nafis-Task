<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    public function testIndexTasksWithFilters()
    {
        $admin = User::factory()->create([
            'role' => 'admin', 
        ]);

        $this->actingAs($admin, 'sanctum');

        Task::factory()->create([
            'status' => 'pending',
            'due_date' => '2024-12-31',
        ]);

        $response = $this->getJson('/api/tasks?status=pending');

        $response->assertStatus(200);

        $response->assertJsonFragment(['status' => 'pending']);
    }

    public function testStoreTask()
    {
        $admin = User::factory()->create([
            'role' => 'admin', 
        ]);
    
        $this->actingAs($admin, 'sanctum');
    
        $data = [
            'title' => 'New Task Title', 
            'description' => 'This is a description for the new task.', 
            'status' => 'pending',
            'due_date' => '2024-12-31',
        ];
    
        $response = $this->postJson('/api/tasks', $data);
    
        $response->assertStatus(200);
    
        $response->assertJsonFragment(['title' => 'New Task Title']);
    }
    

    

    public function testAssignUsersToTask()
    {
        $admin = User::factory()->create([
            'role' => 'admin', 
        ]);

        $user = User::factory()->create();

        $this->actingAs($admin, 'sanctum');

        $task = Task::factory()->create();

        $response = $this->postJson("/api/assgin/{$task->id}", [
            'user_ids' => [$user->id]
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment(['message' => 'Users assigned successfully']);
    }

    public function testUnauthorizedAccess()
    {
        $response = $this->getJson('/api/tasks');

        $response->assertStatus(401);
    }

    public function testForbiddenAccessForNonAdmin()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(403);
    }


    public function testShowTask()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');
    
        $task = Task::factory()->create();
    
        $response = $this->getJson("/api/tasks/{$task->id}");
    
        $response->assertStatus(200);
        $response->assertJsonFragment(['description' => $task->description]);
        $response->assertJsonFragment(['due_date' => $task->due_date]);
    }

    public function testUpdateTask()
{
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin, 'sanctum');

    $task = Task::factory()->create();

    $updatedData = [
        'title' => 'Updated Task Title',
        'description' => 'Updated description',
        'status' => 'completed',
        'due_date' => '2024-12-31',
    ];

    $response = $this->putJson("/api/tasks/{$task->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJsonFragment(['title' => 'Updated Task Title']);
}

public function testDeleteTask()
{
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin, 'sanctum');

    $task = Task::factory()->create();

    $response = $this->deleteJson("/api/tasks/{$task->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment(['message' => 'Deleted Success']);

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
}

public function testGetTasksByUser()
{
    $user = User::factory()->create(['role' => 'admin']); 
    $this->actingAs($user, 'sanctum');

    $task = Task::factory()->create();
    $task->users()->attach($user);

    $response = $this->getJson("/api/task/{$user->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment(['id' => $task->id]);
}



}
