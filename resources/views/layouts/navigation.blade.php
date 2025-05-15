@php
    // Vérification des messages non lus
    use App\Models\Message;
    $unreadCount = auth()->check() ? Message::where('receiver_id', auth()->id())->where('status', 'sent')->count() : 0;
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">SmartSchool</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('eleves.index') }}">Eleves</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('matieres.index') }}">Matieres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('classes.index') }}">Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('salles.index') }}">Salles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('enseignants.index') }}">enseignants</a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>

                    @if (Route::has('register') && !request()->is('login/admin') && !request()->is('login/enseignant') && !request()->is('login/eleve'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
                    @endif
                @endguest

                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Mon espace</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="{{ route('messages.index') }}">
                            <i class="bi bi-chat-dots" style="font-size: 1.4rem;"></i>
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
