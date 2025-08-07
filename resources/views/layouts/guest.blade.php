<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Painel WPP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Fonte e estilo base --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- ou use o seu CSS padrão --}}

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }
        .auth-container {
            max-width: 400px;
            margin: 80px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        {{ $slot }}
    </div>
</body>
</html>
