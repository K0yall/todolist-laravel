@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-folder"></i>
        {{ $category->name }}
    </h1>
    <div class="page-actions">
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary">
            <i class="fas fa-edit"></i>
            Editar Categoria
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
    </div>
</div>

<div class="category-stats">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $tasks->total() }}</h3>
            <p>Total de Tarefas</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon completed">
            <i class="fas fa-check"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $tasks->where('completed', true)->count() }}</h3>
            <p>Concluídas</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon pending">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $tasks->where('completed', false)->count() }}</h3>
            <p>Pendentes</p>
        </div>
    </div>
</div>

<div class="tasks-section">
    <h2 class="section-title">Tarefas desta Categoria</h2>
    
    @if($tasks->count() > 0)
        <div class="tasks-grid">
            @foreach ($tasks as $task)
                <div class="task-card {{ $task->completed ? 'completed' : '' }} {{ $task->isOverdue() ? 'overdue' : '' }}">
                    <div class="task-header">
                        <div class="task-priority" style="background-color: {{ $task->priority_color }}">
                            {{ ucfirst($task->priority) }}
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($tasks->hasPages())
            <div class="pagination-wrapper">
                {{ $tasks->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fas fa-tasks"></i>
            <h3>Nenhuma tarefa nesta categoria</h3>
            <p>Crie uma nova tarefa para esta categoria!</p>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Criar Tarefa
            </a>
        </div>
    @endif
</div>
@endsection