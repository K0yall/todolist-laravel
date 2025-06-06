<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') - ToDoList</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script defer src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <nav>
        <a href="{{ route('tasks.index') }}">Tarefas</a>
        <a href="{{ route('categories.index') }}">Categorias</a>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteForms = document.querySelectorAll('form.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', e => {
                if(!confirm('Tem certeza que deseja excluir esta tarefa?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>

</body>
</html>
