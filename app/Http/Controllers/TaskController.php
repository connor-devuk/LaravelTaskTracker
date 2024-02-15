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

        Task::create($validated);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $validated  = $request->validateWithBag('taskUpdate', [
            'name' => 'required|string|max:180',
            'description' => 'required|string|max:500',
            'status' => 'required|in:pending,complete,overdue',
            'due_by' => 'required|date_format:d/m/Y',
        ]);

        $task->update($validated);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()>with('success', 'Task deleted successfully.');
    }
}
