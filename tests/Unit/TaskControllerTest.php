<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase; // This trait resets the database after each test

    /** @test */
    public function it_can_create_a_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user); // Authenticate as the created user

        $taskData = [
            'name' => 'Test Task',
            'description' => 'Test Description',
            'due_by' => now()->addDays(7)->format('Y-m-d'),
            'status' => 'pending',
        ];

        $response = $this->post(route('tasks.create'), $taskData);

        $response->assertStatus(302); // Assuming it redirects after creating a task
        $this->assertDatabaseHas('tasks', array_merge($taskData, ['user_id' => $user->id]));
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::create([
            'user_id' => $user->id, // Assign the authenticated user's ID to user_id
            'name' => 'Task to Update',
            'description' => 'Description to Update',
            'due_by' => now()->addDays(7)->format('Y-m-d'),
        ]);

        $updatedData = [
            'name' => 'Updated Task Name',
            'description' => 'Updated Description',
            'due_by' => now()->addDays(14)->format('Y-m-d'),
        ];

        $response = $this->patch(route('tasks.update', $task), $updatedData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', array_merge($updatedData, ['user_id' => $user->id]));
    }

    /** @test */
    public function it_can_change_task_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::create([
            'user_id' => $user->id, // Assign the authenticated user's ID to user_id
            'name' => 'Task to Update Status',
            'description' => 'Description to Update Status',
            'due_by' => now()->addDays(7)->format('Y-m-d'),
            'status' => 'pending',
        ]);

        $response = $this->get(route('tasks.update.status', [$task, 'complete']));

        $response->assertStatus(302); // Assuming it redirects after changing status
        $this->assertEquals('complete', $task->refresh()->status);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::create([
            'user_id' => $user->id, // Assign the authenticated user's ID to user_id
            'name' => 'Task to Delete',
            'description' => 'Description to Delete',
            'due_by' => now()->addDays(7)->format('Y-m-d'),
            'status' => 'pending',
        ]);

        $response = $this->delete(route('tasks.delete', $task));

        $response->assertStatus(302); // Assuming it redirects after deleting a task
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
