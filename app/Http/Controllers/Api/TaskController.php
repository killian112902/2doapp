<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'deadline' => ['nullable', 'date'],
        ]);

        $task = Task::create([
            'title' => $data['title'],
            'deadline' => $data['deadline'] ?? null,
            'user_id' => Auth::id(),
        ]);

        return new TaskResource($task);
    }

    public function update(Request $request, Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);

        $data = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'is_done' => ['sometimes', 'boolean'],
            'deadline' => ['nullable', 'date'],
        ]);

        $task->update($data);

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}
