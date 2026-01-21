<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Show all tasks
    public function index() {
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        $user = Auth::user();
        return view('index', compact('tasks', 'user'));
    }

    // Lightweight JSON feed for real-time polling
    public function json() {
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        $total = $tasks->count();
        $done = $tasks->where('is_done', true)->count();
        $active = $total - $done;
        $progress = $total ? round(($done / $total) * 100) : 0;
        $compliment = $done >= 3 ? 'You are productive' : 'You are having a good time';

        return response()->json([
            'tasks' => $tasks->map(function (Task $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'details' => $task->details,
                    'is_done' => (bool) $task->is_done,
                    'created_at' => optional($task->created_at)->format('M d, Y'),
                    'deadline' => $task->deadline,
                ];
            })->values(),
            'stats' => [
                'total' => $total,
                'done' => $done,
                'active' => $active,
                'progress' => $progress,
                'compliment' => $compliment,
            ],
        ]);
    }

    // Store new task
    public function store(Request $request) {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string', 'max:5000'],
            'deadline' => ['nullable', 'date'],
        ]);

        Task::create([
            'title' => $request->title,
            'details' => $request->details,
            'user_id' => Auth::id(),
            'deadline' => $request->deadline,
        ]);

        return back()->with('status', 'Task added');
    }

    // Update task (edit fields or toggle done)
    public function update(Request $request, Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);

        // If title/details/deadline are present, treat as edit
        if ($request->hasAny(['title', 'details', 'deadline'])) {
            $data = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'details' => ['nullable', 'string', 'max:5000'],
                'deadline' => ['nullable', 'date'],
            ]);

            $task->update([
                'title' => $data['title'],
                'details' => $data['details'] ?? null,
                'deadline' => $data['deadline'] ?? null,
            ]);

            return back()->with('status', 'Task updated');
        }

        // Otherwise toggle done state
        $nextState = ! $task->is_done;

        $task->update([
            'is_done' => $nextState
        ]);

        return back()->with('status', $nextState ? 'Task marked done' : 'Task marked active');
    }

    // Delete task
    public function destroy(Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);

        $task->delete();
        return back()->with('status', 'Task deleted');
    }
}
