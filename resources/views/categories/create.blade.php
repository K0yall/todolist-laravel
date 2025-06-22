@extends('layouts.app')

@section('title', 'Criar Categoria')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-plus"></i>
        Criar Nova Categoria
    </h1>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('categories.store') }}" class="category-form">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">
                <i class="fas fa-folder"></i>
                Nome da Categoria *
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   class="form-input @error('name') error @enderror"
                   placeholder="Digite o nome da categoria"
                   required>
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Salvar Categoria
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
        </div>
    </form>
</div>
@endsection