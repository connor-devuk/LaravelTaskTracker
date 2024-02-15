<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        /*
        This is where we validate the request to ensure no bad data gets accepted; we're using WithBag
        so it can keep the modal open in case of validation errors (better ux experience)
        */
        $validated  = $request->validateWithBag('taskCreation', [
            'name' => 'required|string|max:180',
            'description' => 'required|string|max:500',
            'due_by' => 'required|date_format:Y-m-d',
        ]);

        /*
        This is where we create the task.
        We are creating it from the user model so it auto fills the user_id field for us :)
        */
        auth()->user()->tasks()->create($validated);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    /**
     * @param Request $request
     * @param Task $task
     * @return RedirectResponse
     */
    public function update(Request $request, Task $task)
    {
        // Let's make sure users can only update their own tasks
        if($task->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'This task does not belong to you!.');
        }

        /*
        This is where we validate the request to ensure no bad data gets accepted; we're using WithBag
        so it can keep the modal open in case of validation errors (better ux experience)
        */
        $validated  = $request->validateWithBag('taskUpdate', [
            'name' => 'required|string|max:180',
            'description' => 'required|string|max:500',
            'due_by' => 'required|date_format:Y-m-d',
        ]);

        // Perform the update
        $task->update($validated);

        // Return back to the page
        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    /**
     * @param Task $task
     * @param $status
     * @return RedirectResponse
     */
    public function status(Task $task, $status)
    {
        // Let's make sure users can only update their own tasks
        if($task->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'This task does not belong to you!.');
        }

        // Update the status to be the new one
        $task->update(['status' => $status]);

        // Return back to the page
        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    /**
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task)
    {
        // Let's make sure users can only delete their own tasks
        if($task->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'This task does not belong to you!.');
        }

        // Delete the task
        $task->delete();

        // Return back to the page
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}
