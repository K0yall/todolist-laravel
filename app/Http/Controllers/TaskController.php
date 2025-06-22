<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('category');

        // Filtro por busca
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filtro por categoria
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filtro por status
        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->completed();
            } elseif ($request->status === 'pending') {
                $query->pending();
            }
        }

        // Filtro por prioridade
        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        // Ordenação
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        $query->orderBy($sortBy, $sortOrder);

        $tasks = $query->paginate(10);
        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:baixa,media,alta',
            'due_date' => 'nullable|date|after_or_equal:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Upload da imagem
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tasks', 'public');
        }

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:baixa,media,alta',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Upload da nova imagem
        if ($request->hasFile('image')) {
            // Remove a imagem antiga
            if ($task->image) {
                Storage::disk('public')->delete($task->image);
            }
            $data['image'] = $request->file('image')->store('tasks', 'public');
        }

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $task)
    {
        // Remove a imagem se existir
        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
    }

    public function complete(Task $task)
    {
        $task->update(['completed' => true]);
        return redirect()->route('tasks.index')->with('success', 'Tarefa marcada como concluída!');
    }

    public function toggleComplete(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        $message = $task->completed ? 'Tarefa marcada como concluída!' : 'Tarefa marcada como pendente!';
        return redirect()->route('tasks.index')->with('success', $message);
    }
}