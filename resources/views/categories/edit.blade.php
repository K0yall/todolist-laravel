@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-edit"></i>
        Editar Categoria
    </h1>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('categories.update', $category) }}" class="category-form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name" class="form-label">
                <i class="fas fa-folder"></i>
                Nome da Categoria *
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $category->name) }}" 
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
                Atualizar Categoria
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
        </div>
    </form>
</div>
@endsection