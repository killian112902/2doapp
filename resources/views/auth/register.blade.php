<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account · To-Do HQ</title>
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
            width: min(480px, 100%);
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
        input[type="text"], input[type="email"], input[type="password"] {
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
        .error { color: var(--danger); font-size: 13px; background: rgba(255, 156, 156, 0.08); border: 1px solid rgba(255, 156, 156, 0.35); padding: 10px 12px; border-radius: 10px; }
        .footer { margin-top: 12px; color: var(--muted); font-size: 13px; text-align: center; }
        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <div class="glow"></div>
        <h1>Create your account</h1>
        <p>Join To-Do HQ and start tracking tasks with your own login.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <div>
                <label for="name">Full name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
            </div>
            <div>
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="row">
                <a href="/login">Already have an account?</a>
                <button class="button" type="submit">Create account</button>
            </div>
        </form>

        <div class="footer">By creating an account you agree to keep your tasks awesome.</div>
    </div>
</body>
</html>
