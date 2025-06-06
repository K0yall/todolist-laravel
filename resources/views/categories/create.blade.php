@extends('layouts.app')

@section('title', 'Criar Categoria')

@section('content')
    <h1>Criar Nova Categoria</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <label for="name">Nome da Categoria:</label><br>
        <input type="text" name="name" id="name" required><br>

        <button type="submit">Salvar</button>
    </form>

    <br>
    <a href="{{ route('categories.index') }}">← Voltar para lista de categorias</a>
@endsection