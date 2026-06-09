<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mundial 2026 | Polla Deportiva</title>
    <style>
        /* Estilos diseñados para verse profesional sin librerías externas */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #051937 0%, #004d7a 100%);
            color: #ffffff;
            font-family: 'Arial Black', sans-serif;
        }

        .container {
            text-align: center;
            padding: 20px;
        }

        h1 {
            font-size: 5rem;
            text-transform: uppercase;
            letter-spacing: -2px;
            margin: 0;
            text-shadow: 4px 4px 0px #000;
        }

        .year {
            color: #fbbf24; /* Color Dorado Mundialista */
            text-shadow: 4px 4px 0px #b45309;
        }

        p {
            font-size: 1.5rem;
            color: #a5f3fc;
            margin-bottom: 40px;
        }

        .btn-login {
            background-color: #e11d48; /* Rojo vibrante */
            color: white;
            padding: 15px 40px;
            font-size: 1.2rem;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            text-transform: uppercase;
            transition: transform 0.2s, background-color 0.3s;
            border: 2px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .btn-login:hover {
            background-color: #9f1239;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Mundial <span class="year">2026</span></h1>
        <p>Tu plataforma oficial de apuestas</p>

        <a href="{{ route('login') }}" class="btn-login">
            Iniciar Sesión
        </a>
    </div>

</body>
</html>
