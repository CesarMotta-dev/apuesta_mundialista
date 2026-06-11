<div
    style="background: linear-gradient(135deg, #051937 0%, #004d7a 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: sans-serif;">

    <div style="
        background: #ffffff;
        padding: 30px;
        border-radius: 15px;
        width: 90%;
        max-width: 400px;
        color: #333;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    ">
        <h2 style="text-align: center; color: #e11d48; text-transform: uppercase; margin-top: 0;">Registrarse</h2>

        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Nombre</label>
                <input type="text" name="name" required
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Correo</label>
                <input type="email" name="email" required
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Contraseña</label>
                <input type="password" name="password" required
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px;">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" required
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">¿Cómo te registras?</label>
                <select name="rol" required
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
                    <option value="apostador">Apostador</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>

            <button type="submit"
                style="width: 100%; padding: 12px; background-color: #059669; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                CREAR MI CUENTA
            </button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}"
                style="color: #e11d48; font-weight: bold; text-decoration: none;">Inicia sesión</a>
        </p>
    </div>
</div>
