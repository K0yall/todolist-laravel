@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-eye"></i>
        Detalhes da Tarefa
    </h1>
    <div class="page-actions">
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-secondary">
            <i class="fas fa-edit"></i>
            Editar
        </a>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
    </div>
</div>

<div class="task-detail-card">
    <div class="task-detail-header">
        <div class="task-title-section">
            <h2 class="task-title">{{ $task->title }}</h2>
            <div class="task-badges">
                <span class="priority-badge" style="background-color: {{ $task->priority_color }}">
                    {{ ucfirst($task->priority) }}
                </span>
                <span class="status-badge {{ $task->completed ? 'completed' : 'pending' }}">
                    <i class="fas {{ $task->completed ? 'fa-check' : 'fa-clock' }}"></i>
                    {{ $task->completed ? 'Concluída' : 'Pendente' }}
                </span>
                @if($task->isOverdue())
                    <span class="status-badge overdue">
                        <i class="fas fa-exclamation-triangle"></i>
                        Atrasada
                    </span>
                @endif
            </div>
        </div>
        
        <div class="task-actions">
            <form method="POST" action="{{ route('tasks.toggle', $task) }}" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn {{ $task->completed ? 'btn-warning' : 'btn-success' }}">
                    <i class="fas {{ $task->completed ? 'fa-undo' : 'fa-check' }}"></i>
                    {{ $task->completed ? 'Marcar como Pendente' : 'Marcar como Concluída' }}
                </button>
            </form>
        </div>
    </div>

    @if($task->image)
        <div class="task-image-section">
            <img src="{{ Storage::url($task->image) }}" alt="Imagem da tarefa" class="task-image-full">
        </div>
    @endif

    <div class="task-detail-content">
        @if($task->description)
            <div class="detail-section">
                <h3 class="detail-title">
                    <i class="fas fa-align-left"></i>
                    Descrição
                </h3>
                <p class="detail-text">{{ $task->description }}</p>
            </div>
        @endif

        <div class="detail-grid">
            <div class="detail-item">
                <h4 class="detail-label">
                    <i class="fas fa-folder"></i>
                    Categoria
                </h4>
                <p class="detail-value">{{ $task->category->name }}</p>
            </div>

            <div class="detail-item">
                <h4 class="detail-label">
                    <i class="fas fa-exclamation"></i>
                    Prioridade
                </h4>
                <p class="detail-value">{{ ucfirst($task->priority) }}</p>
            </div>

            @if($task->due_date)
                <div class="detail-item">
                    <h4 class="detail-label">
                        <i class="fas fa-calendar"></i>
                        Data de Vencimento
                    </h4>
                    <p class="detail-value {{ $task->isOverdue() ? 'text-danger' : '' }}">
                        {{ $task->due_date->format('d/m/Y') }}
                        @if($task->isOverdue())
                            <span class="text-danger">(Atrasada)</span>
                        @endif
                    </p>
                </div>
            @endif

            <div class="detail-item">
                <h4 class="detail-label">
                    <i class="fas fa-calendar-plus"></i>
                    Criada em
                </h4>
                <p class="detail-value">{{ $task->created_at->format('d/m/Y H:i') }}</p>
            </div>

            @if($task->updated_at != $task->created_at)
                <div class="detail-item">
                    <h4 class="detail-label">
                        <i class="fas fa-calendar-edit"></i>
                        Atualizada em
                    </h4>
                    <p class="detail-value">{{ $task->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection