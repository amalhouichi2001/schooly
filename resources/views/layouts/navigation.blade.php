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

                {{-- ADMIN --}}
                @if(Auth::user()->isAdmin())
                <li class="nav-item"><a class="nav-link" href="{{ route('eleves.index') }}">Élèves</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('matieres.index') }}">Matières</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('classes.index') }}">Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('salles.index') }}">Salles</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('enseignants.index') }}">Enseignants</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('exercices.index') }}">Exercices</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('emploi.index') }}">Emplois</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('parents.inscriptions') }}">Inscription</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('depenses.index') }}">dependences</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('financial-records.index') }}">salaire</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('conges.index') }}">congé</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">evenements</a></li>
                @endif

                {{-- PARENT --}}
                @if(Auth::user()->isParent())
                <li class="nav-item"><a class="nav-link" href="{{ route('parents.enfants') }}">Mes enfants</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('parents.inscriptions') }}">Inscription</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('emploi.index') }}">Emploi de temps</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">evenements</a></li>
                @endif

                {{-- ÉLÈVE --}}
                @if(Auth::user()->isEleve())
                <li class="nav-item"><a class="nav-link" href="{{ route('classes.bulletin', [Auth::user()->classe_id, Auth::user()->id]) }}">Mon bulletin</a></li>
                
                <li class="nav-item"><a class="nav-link" href="{{ route('eleves.exercices') }}">Mes exercices</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('emploi.index') }}">Mon emploi</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">evenements</a></li>
                @endif
                 @if(Auth::user()->isEnseignant())
                
                
                <li class="nav-item"><a class="nav-link" href="{{ route('exercices.index') }}">Mes exercices</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('emploi.index') }}">Mon emploi</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('classes.index') }}">Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('emploi.index') }}">Emplois</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('financial-records.index') }}">salaire</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('conges.index') }}">congé</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">evenements</a></li>
                @endif
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