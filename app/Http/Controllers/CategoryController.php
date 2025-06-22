<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('tasks')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function show(Category $category)
    {
        $tasks = $category->tasks()->paginate(10);
        return view('categories.show', compact('category', 'tasks'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Category $category)
    {
        if ($category->tasks()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Não é possível excluir uma categoria que possui tarefas.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoria excluída com sucesso!');
    }
}