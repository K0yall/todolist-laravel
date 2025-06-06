@extends('layouts.app')

@section('title', 'Lista de Tarefas')

@section('content')
<div class="container">
    <h1>Lista de Tarefas</h1>

    <form method="GET" action="{{ route('tasks.index') }}" class="filter-form">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar título..." />
        <select name="category">
            <option value="">Todas Categorias</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <a href="{{ route('tasks.create') }}" class="new-task-btn">+ Nova Tarefa</a>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Concluído</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->category->name ?? 'Sem categoria' }}</td>
                <td>{{ $task->completed ? 'Sim' : 'Não' }}</td>
                <td class="actions">
                    <a href="{{ route('tasks.edit', $task) }}">Editar</a>

                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Excluir esta tarefa?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="no-tasks">Nenhuma tarefa encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        {{ $tasks->withQueryString()->links() }}
    </div>
</div>
@endsection
