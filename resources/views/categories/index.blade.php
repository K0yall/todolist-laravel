@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-folder"></i>
        Categorias
    </h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Nova Categoria
    </a>
</div>

<div class="categories-grid">
    @forelse ($categories as $category)
        <div class="category-card">
            <div class="category-header">
                <h3 class="category-name">
                    <i class="fas fa-folder"></i>
                    {{ $category->name }}
                </h3>
                <span class="task-count">
                    {{ $category->tasks_count }} 
                    {{ $category->tasks_count == 1 ? 'tarefa' : 'tarefas' }}
                </span>
            </div>
            
            <div class="category-actions">
                <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline">
                    <i class="fas fa-eye"></i>
                    Ver Tarefas
                </a>
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-edit"></i>
                    Editar
                </a>
                <form method="POST" action="{{ route('categories.destroy', $category) }}" style="display: inline;" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" {{ $category->tasks_count > 0 ? 'disabled title=Não é possível excluir categoria com tarefas' : '' }}>
                        <i class="fas fa-trash"></i>
                        Excluir
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <h3>Nenhuma categoria encontrada</h3>
            <p>Crie sua primeira categoria para organizar suas tarefas!</p>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Criar Categoria
            </a>
        </div>
    @endforelse
</div>
@endsection