<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
    <script src="https://unpkg.com/htmx.org@2.0.4"></script>
    @livewireStyles
    <title>@yield('title') | Administration</title>
    <style>
        @layer reset {
            button {
                all: unset;
            }
        }

        .htmx-indicator {
            display: none;
        }

        .htmx-request .htmx-indicator {
            display: inline-block;
        }

        .htmx-request.htmx-indicator {
            display: inline-block;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Les projets</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @php
            $route = request()->route()->getName();
        @endphp
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => str_contains($route, 'project.')])
                       href="{{ route('admin.project.index') }}">
                        Gérer les projets
                    </a>
                </li>
            </ul>
            <div class="ms-auto">
                @auth
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                           <a
                               href="#"
                               class="nav-link dropdown-toggle"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false"
                           >{{ auth()->user()->name }}
                           </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">Profil</a></li>
                                <li> <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button class="dropdown-item">Se déconnecter</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </div>
</nav>
<div class="container mt-5">
    @include('shared.flash')
    @yield('content')
</div>
<script>
    document.querySelectorAll('select[multiple]').forEach((el) => {
        new TomSelect(el, {
            plugins: {
                remove_button: {
                    title: 'Supprimer'
                }
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts
</body>
</html>
