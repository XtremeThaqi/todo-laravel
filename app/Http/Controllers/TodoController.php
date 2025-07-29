<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::latest()->paginate(10);
        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable'
        ]);

        Todo::create($request->all());

        return redirect()->route('todos.index')
            ->with('success', 'Todo created successfully.');
    }

    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        $rules = [
            'completed' => 'sometimes|boolean'
        ];
        
        // Only require title if it's being updated
        if ($request->has('title')) {
            $rules['title'] = 'required|max:255';
            $rules['description'] = 'nullable';
        }

        $validated = $request->validate($rules);

        $todo->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'completed' => $todo->completed
            ]);
        }

        return redirect()->route('todos.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        
        return redirect()->route('todos.index')
            ->with('success', 'Task deleted successfully!');
    }

    public function toggle(Request $request, Todo $todo)
    {
        try {
            $newState = !$todo->completed;
            $todo->update(['completed' => $newState]);
            
            return response()->json([
                'success' => true,
                'completed' => $newState
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}