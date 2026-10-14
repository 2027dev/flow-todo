<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('position')->orderBy('id')->get();

        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $position = Task::max('position') + 1;

        $task = Task::create([
            'title' => $data['title'],
            'position' => $position,
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'completed' => ['sometimes', 'boolean'],
        ]);

        $task->update($data);

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
