<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validated  = $request->validateWithBag('taskCreation', [
            'name' => 'required|string|max:180',
            'description' => 'required|string|max:500',
            'due_by' => 'required|date_format:Y-m-d',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        if($task->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'This task does not belong to you!.');
        }

        $validated  = $request->validateWithBag('taskUpdate', [
            'name' => 'sometimes|string|max:180',
            'description' => 'sometimes|string|max:500',
            'status' => 'sometimes|in:pending,complete,overdue',
            'due_by' => 'sometimes|date_format:d/m/Y',
        ]);

        $task->update($validated);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if($task->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'This task does not belong to you!.');
        }

        $task->delete();
        return redirect()->back()>with('success', 'Task deleted successfully.');
    }
}
