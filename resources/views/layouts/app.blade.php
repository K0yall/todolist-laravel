<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TodoList') - Sistema de Gerenciamento de Tarefas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <i class="fas fa-tasks"></i>
                <span>TodoList</span>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <i class="fas fa-list-check"></i>
                        Tarefas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i>
                        Categorias
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} TodoList - Sistema de Gerenciamento de Tarefas</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>