<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Gestionnaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
{{--@vite(['resources/css/app.css', 'resources/js/app.js'])--}}
</head>
<body>
<nav id="navbar-example2" class="navbar bg-body-secondary px-3 mb-3">
    <a class="navbar-brand" href="#">Gestionnaire de tâches collaboratif</a>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('project.index') }}">Projets</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">Connexion</a>
        </li>
    </ul>
</nav>
    @yield('content')
</body>
</html>
