@extends('layouts.app')

@section('title', 'Lista de Tarefas')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-list-check"></i>
        Lista de Tarefas
    </h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Nova Tarefa
    </a>
</div>

<div class="filters-card">
    <form method="GET" action="{{ route('tasks.index') }}" class="filters-form">
        <div class="filter-group">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Buscar por título ou descrição..."
                   class="form-input">
        </div>
        
        <div class="filter-group">
            <select name="category" class="form-select">
                <option value="">Todas as Categorias</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <select name="status" class="form-select">
                <option value="">Todos os Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendentes</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluídas</option>
            </select>
        </div>

        <div class="filter-group">
            <select name="priority" class="form-select">
                <option value="">Todas as Prioridades</option>
                <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Média</option>
                <option value="baixa" {{ request('priority') == 'baixa' ? 'selected' : '' }}>Baixa</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-search"></i>
                Filtrar
            </button>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline">
                <i class="fas fa-times"></i>
                Limpar
            </a>
        </div>
    </form>
</div>

<div class="tasks-grid">
    @forelse ($tasks as $task)
        <div class="task-card {{ $task->completed ? 'completed' : '' }} {{ $task->isOverdue() ? 'overdue' : '' }}">
            <div class="task-header">
                <div class="task-priority" style="background-color: {{ $task->priority_color }}">
                    {{ ucfirst($task->priority) }}
                </div>
                <div class="task-actions">
                    <form method="POST" action="{{ route('tasks.toggle', $task) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-icon" title="{{ $task->completed ? 'Marcar como pendente' : 'Marcar como concluída' }}">
                            <i class="fas {{ $task->completed ? 'fa-undo' : 'fa-check' }}"></i>
                        </button>
                    </form>
                </div>
            </div>

            @if($task->image)
                <div class="task-image">
                    <img src="{{ Storage::url($task->image) }}" alt="Imagem da tarefa">
                </div>
            @endif

            <div class="task-content">
                <h3 class="task-title">{{ $task->title }}</h3>
                
                @if($task->description)
                    <p class="task-description">{{ Str::limit($task->description, 100) }}</p>
                @endif

                <div class="task-meta">
                    <span class="task-category">
                        <i class="fas fa-folder"></i>
                        {{ $task->category->name }}
                    </span>
                    
                    @if($task->due_date)
                        <span class="task-due-date {{ $task->isOverdue() ? 'overdue' : '' }}">
                            <i class="fas fa-calendar"></i>
                            {{ $task->due_date->format('d/m/Y') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="task-footer">
                <div class="task-status">
                    @if($task->completed)
                        <span class="status-badge completed">
                            <i class="fas fa-check"></i>
                            Concluída
                        </span>
                    @else
                        <span class="status-badge pending">
                            <i class="fas fa-clock"></i>
                            Pendente
                        </span>
                    @endif
                </div>

                <div class="task-actions">
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline">
                        <i class="fas fa-eye"></i>
                        Ver
                    </a>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i>
                        Editar
                    </a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display: inline;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-tasks"></i>
            <h3>Nenhuma tarefa encontrada</h3>
            <p>Comece criando sua primeira tarefa!</p>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Criar Tarefa
            </a>
        </div>
    @endforelse
</div>

@if($tasks->hasPages())
    <div class="pagination-wrapper">
        {{ $tasks->withQueryString()->links() }}
    </div>
@endif
@endsection