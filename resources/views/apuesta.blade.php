<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Apuestas Mundialistas</title>
</head>
<body>
    <h1>Haz tu apuesta para el Mundial</h1>

    <form action="/enviar-apuesta" method="POST">

        @csrf

        <div>
            <label>Tu nombre:</label>
            <input type="text" name="user_name" required>
        </div>

        <br>
        <div>
            <label>Selecciona tu equipo:</label>
            <select name="team_choice">
                <option value="colombia">Colombia</option>
                <option value="argentina">Argentina</option>
                <option value="brasil">Brasil</option>
            </select>
        </div>

        <br>
        <div>
            <label>Monto a apostar ($):</label>
            <input type="number" name="bet_amount" required>
        </div>

        <input type="hidden" name="match_id" value="PARTIDO-1234">

        <br><br>
        <button type="submit">Apostar</button>
    </form>

    @if(session('mensaje'))
        <hr>
        <h3 style="color: green;">
            {{ session('mensaje') }}
        </h3>
    @endif
</body>
</html>
