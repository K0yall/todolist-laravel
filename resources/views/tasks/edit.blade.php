@extends('layouts.app')

@section('title', 'Editar Tarefa')

@section('content')
    <h1>Editar Tarefa</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Título:</label><br>
        <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" required><br>

        <label for="description">Descrição:</label><br>
        <textarea id="description" name="description">{{ old('description', $task->description) }}</textarea><br>

        <label for="category_id">Categoria:</label><br>
        <select id="category_id" name="category_id" required>
            <option value="">Selecione</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ (old('category_id', $task->category_id) == $category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select><br>

        <label for="completed">
            <input type="checkbox" id="completed" name="completed" value="1" {{ old('completed', $task->completed) ? 'checked' : '' }}>
            Concluída
        </label><br>

        <button type="submit">Atualizar</button>
        <a href="{{ route('tasks.index') }}"><button type="button">Voltar</button></a>
    </form>
@endsection
