<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In · To-Do HQ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0b1021;
            --panel: rgba(17, 25, 52, 0.78);
            --glass: rgba(255, 255, 255, 0.05);
            --text: #e7ecff;
            --muted: #9db0d9;
            --accent: #7cf3c2;
            --accent-2: #5bc8ff;
            --danger: #ff9c9c;
            --radius: 18px;
            --shadow: 0 18px 50px rgba(0, 0, 0, 0.35);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Space Grotesk', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text);
            background: radial-gradient(circle at 12% 20%, rgba(124, 243, 194, 0.15), transparent 36%),
                        radial-gradient(circle at 88% 12%, rgba(91, 200, 255, 0.18), transparent 38%),
                        linear-gradient(180deg, #050712 0%, #0b1021 55%, #050712 100%);
            display: grid;
            place-items: center;
            padding: 28px;
        }
        .card {
            width: min(460px, 100%);
            background: var(--panel);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 22px;
            box-shadow: var(--shadow);
            padding: 26px 26px 28px;
            position: relative;
            overflow: hidden;
        }
        .glow {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 50%, rgba(124, 243, 194, 0.12), transparent 42%),
                        radial-gradient(circle at 80% 30%, rgba(91, 200, 255, 0.14), transparent 45%);
            pointer-events: none;
        }
        h1 { margin: 0 0 8px; letter-spacing: -0.5px; }
        p { margin: 0 0 18px; color: var(--muted); line-height: 1.6; }
        form { position: relative; z-index: 1; display: grid; gap: 14px; }
        label { font-size: 13px; color: var(--muted); }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 14px 15px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            color: var(--text);
            font-size: 15px;
            transition: border 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }
        input:focus {
            outline: none;
            border-color: rgba(124, 243, 194, 0.7);
            box-shadow: 0 0 0 4px rgba(124, 243, 194, 0.12);
            transform: translateY(-1px);
        }
        .button {
            padding: 13px 16px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            font-size: 15px;
            color: #031017;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
            box-shadow: 0 12px 22px rgba(124, 243, 194, 0.22);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .button:hover { transform: translateY(-1px); box-shadow: 0 14px 24px rgba(124, 243, 194, 0.28); }
        .button:active { transform: translateY(0); box-shadow: 0 10px 18px rgba(124, 243, 194, 0.2); }
        .row { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .checkbox { display: flex; align-items: center; gap: 8px; color: var(--muted); font-size: 13px; }
        .error { color: var(--danger); font-size: 13px; background: rgba(255, 156, 156, 0.08); border: 1px solid rgba(255, 156, 156, 0.35); padding: 10px 12px; border-radius: 10px; }
        .footer { margin-top: 10px; color: var(--muted); font-size: 13px; text-align: center; }
        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }

        .loading-overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(5, 7, 18, 0.82);
            backdrop-filter: blur(6px);
            z-index: 9999;
        }

        .loading-card {
            background: var(--panel);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 24px;
            width: min(420px, 90%);
            box-shadow: var(--shadow);
            text-align: center;
        }

        .loading-card h2 { margin: 0 0 8px; letter-spacing: -0.3px; }
        .loading-card p { margin: 0; color: var(--muted); }

        .spinner {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.08);
            border-top-color: var(--accent);
            margin: 0 auto 14px;
            animation: spin 0.9s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="loading-overlay" id="login-loading">
        <div class="loading-card">
            <div class="spinner"></div>
            <h2 id="loading-title">Signing you in…</h2>
            <p></p>
        </div>
    </div>
    <div class="card">
        <div class="glow"></div>
        <h1>Welcome back</h1>
        <p>Sign in to access your tasks. Use the email/password stored in the users table.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/login" id="login-form">
            @csrf
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>
            <div class="row">
                <label class="checkbox">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <button class="button" type="submit">Sign in</button>
            </div>
            <div style="margin-top:10px; text-align: right;">
                <a href="/forgot-password">Forgot your password?</a>
            </div>
        </form>

        <div class="footer">Need an account? <a href="/register">Create one here.</a></div>
    </div>

    <script>
        const form = document.getElementById('login-form');
        const emailInput = document.getElementById('email');
        const overlay = document.getElementById('login-loading');
        const overlayTitle = document.getElementById('loading-title');

        form?.addEventListener('submit', () => {
            overlayTitle.textContent = 'Signing you in…';
            overlay.style.display = 'flex';
        });
    </script>
</body>
</html>
