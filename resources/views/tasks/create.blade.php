@extends('layouts.app')

@section('title', 'Criar Tarefa')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-plus"></i>
        Criar Nova Tarefa
    </h1>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data" class="task-form">
        @csrf
        
        <div class="form-row">
            <div class="form-group">
                <label for="title" class="form-label">
                    <i class="fas fa-heading"></i>
                    Título *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
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
                          class="form-textarea @error('description') error @enderror">{{ old('description') }}</textarea>
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
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    <option value="baixa" {{ old('priority') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="media" {{ old('priority') == 'media' ? 'selected' : '' }}>Média</option>
                    <option value="alta" {{ old('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
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
                       value="{{ old('due_date') }}" 
                       class="form-input @error('due_date') error @enderror"
                       min="{{ date('Y-m-d') }}">
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
                           {{ old('completed') ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    Marcar como concluída
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Salvar Tarefa
            </button>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
        </div>
    </form>
</div>
@endsection