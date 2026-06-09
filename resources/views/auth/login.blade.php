<div
    style="background: linear-gradient(135deg, #051937 0%, #004d7a 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; color: white; font-family: sans-serif;">
    <div
        style="background: #ffffff; padding: 40px; border-radius: 15px; width: 100%; max-width: 400px; color: #333; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
        <h2 style="text-align: center; color: #e11d48; text-transform: uppercase;">Inicia Sesión</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Correo Electrónico</label>
                <input type="email" name="email"
                    style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label>Contraseña</label>
                <input type="password" name="password"
                    style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <button type="submit"
                style="width: 100%; padding: 12px; background-color: #e11d48; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                ENTRAR A LA CANCHA
            </button>
            <div style="margin-top: 20px; text-align: center; font-size: 0.9rem;">

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        style="color: #64748b; text-decoration: none; display: block; margin-bottom: 10px;">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                <p style="color: #333;">
                    ¿Aún no tienes cuenta?
                    <a href="{{ route('register') }}" style="color: #e11d48; font-weight: bold; text-decoration: none;">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
