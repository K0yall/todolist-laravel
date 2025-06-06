@extends('layouts.app')

@section('title', 'Criar Tarefa')

@section('content')
    <h1>Criar Nova Tarefa</h1>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <label>Título</label><br />
        <input type="text" name="title" value="{{ old('title') }}" required><br />

        <label>Descrição</label><br />
        <textarea name="description">{{ old('description') }}</textarea><br />

        <label>Categoria</label><br />
        <select name="category_id" required>
            <option value="">Selecione uma categoria</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select><br />

        <label>Concluído</label>
        <input type="checkbox" name="completed" value="1" {{ old('completed') ? 'checked' : '' }}><br /><br />

        <button type="submit">Salvar</button>
    </form>
@endsection