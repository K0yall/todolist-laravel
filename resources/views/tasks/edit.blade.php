@extends('layouts.app')

@section('title', 'Editar Tarefa')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-edit"></i>
        Editar Tarefa
    </h1>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('tasks.update', $task) }}" enctype="multipart/form-data" class="task-form">
        @csrf
        @method('PUT')
        
        <div class="form-row">
            <div class="form-group">
                <label for="title" class="form-label">
                    <i class="fas fa-heading"></i>
                    Título *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $task->title) }}" 
                       class="form-input @error('title') error @enderror"
                       required>
                @error('title')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="description" class="form-label">
                    <i class="fas fa-align-left"></i>
                    Descrição
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          class="form-textarea @error('description') error @enderror">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category_id" class="form-label">
                    <i class="fas fa-folder"></i>
                    Categoria *
                </label>
                <select id="category_id" 
                        name="category_id" 
                        class="form-select @error('category_id') error @enderror" 
                        required>
                    <option value="">Selecione uma categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="priority" class="form-label">
                    <i class="fas fa-exclamation"></i>
                    Prioridade *
                </label>
                <select id="priority" 
                        name="priority" 
                        class="form-select @error('priority') error @enderror" 
                        required>
                    <option value="">Selecione a prioridade</option>
                    <option value="baixa" {{ old('priority', $task->priority) == 'baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="media" {{ old('priority', $task->priority) == 'media' ? 'selected' : '' }}>Média</option>
                    <option value="alta" {{ old('priority', $task->priority) == 'alta' ? 'selected' : '' }}>Alta</option>
                </select>
                @error('priority')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="due_date" class="form-label">
                    <i class="fas fa-calendar"></i>
                    Data de Vencimento
                </label>
                <input type="date" 
                       id="due_date" 
                       name="due_date" 
                       value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}" 
                       class="form-input @error('due_date') error @enderror">
                @error('due_date')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image" class="form-label">
                    <i class="fas fa-image"></i>
                    Imagem
                </label>
                <input type="file" 
                       id="image" 
                       name="image" 
                       class="form-input @error('image') error @enderror"
                       accept="image/*">
                @if($task->image)
                    <div class="current-image">
                        <p class="image-label">Imagem atual:</p>
                        <img src="{{ Storage::url($task->image) }}" alt="Imagem atual" class="current-image-preview">
                    </div>
                @endif
                @error('image')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-checkbox">
                    <input type="checkbox" 
                           name="completed" 
                           value="1" 
                           {{ old('completed', $task->completed) ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    Marcar como concluída
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Atualizar Tarefa
            </button>
            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
        </div>
    </form>
</div>
@endsection