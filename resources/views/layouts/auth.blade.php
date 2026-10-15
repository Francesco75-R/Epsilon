<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Epsilon Togo - Petites Annonces en Ligne')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Epsilon -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

    <!-- Conteneur pour notifications Toast -->
    <div class="toast-container" id="toast-container"></div>

    <!-- Zone principale -->
    <main>
        @yield('content')
    </main>

    <!-- JS Epsilon -->
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>