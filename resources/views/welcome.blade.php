<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartSchool Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgb(232, 233, 235));
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 650px;
            background: linear-gradient(to right, #4e73df, #1cc88a);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .btn-custom {
            background-color: white;
            color: #4e73df;
            border: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #f1f1f1;
            color: #1cc88a;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <h1 class="mb-4">Bienvenue sur <strong>SmartSchool Manager</strong></h1>
    <p class="lead">Plateforme intelligente pour les administrateurs, enseignants, élèves et parents.</p>

    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-custom mt-4">Accéder au tableau de bord</a>
    @else
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('login') }}" class="btn btn-custom px-4">Se connecter</a>
            <a href="{{ route('register') }}" class="btn btn-custom px-4">S'inscrire</a>
        </div>
    @endauth
</div>

</body>
</html>
