@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('content')
    <h1>Editar Categoria</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nome da Categoria:</label><br>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="{{ route('categories.index') }}">← Voltar para lista de categorias</a>
@endsection
