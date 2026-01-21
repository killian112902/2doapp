<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings · To-Do HQ</title>
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
            padding: 28px;
            display: flex;
            justify-content: center;
        }
        .shell {
            width: min(900px, 100%);
            background: var(--panel);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 22px;
            box-shadow: var(--shadow);
            padding: 24px 26px 28px;
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
        header { position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 18px; flex-wrap: wrap; }
        h1 { margin: 0; letter-spacing: -0.4px; }
        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }
        form { position: relative; z-index: 1; display: grid; gap: 14px; margin-top: 10px; }
        label { font-size: 13px; color: var(--muted); }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"] {
            width: 100%;
            padding: 14px 15px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            color: var(--text);
            font-size: 15px;
            transition: border 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }
        input:focus { outline: none; border-color: rgba(124, 243, 194, 0.7); box-shadow: 0 0 0 4px rgba(124, 243, 194, 0.12); transform: translateY(-1px); }
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
        .status { margin-top: 4px; font-size: 13px; color: var(--accent); }
        .row { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .card { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px; padding: 14px; }
        .avatar { width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255, 255, 255, 0.12); box-shadow: 0 8px 20px rgba(0,0,0,0.25); }
        .error { color: #ffb3b3; font-size: 13px; }
        .toast-stack { position: fixed; top: 16px; right: 16px; display: grid; gap: 10px; z-index: 9999; }
        .toast { min-width: 260px; padding: 12px 14px; border-radius: 12px; border: 1px solid rgba(124, 243, 194, 0.4); background: rgba(17, 25, 52, 0.9); color: var(--text); box-shadow: var(--shadow); opacity: 0; transform: translateY(-8px); transition: opacity 0.25s ease, transform 0.25s ease; }

        @media (max-width: 720px) {
            body { padding: 18px; }
            .shell { padding: 18px; }
            .row { flex-direction: column; align-items: flex-start; }
            .row .button, .row a { width: 100%; text-align: center; }
            header { align-items: flex-start; }
            .avatar { width: 64px; height: 64px; }
        }

        @media (max-width: 480px) {
            body { padding: 14px; }
            .shell { border-radius: 16px; padding: 16px; }
            .card { padding: 12px; }
            input[type="text"], input[type="email"], input[type="password"], input[type="date"] { font-size: 15px; }
            .row { gap: 8px; }
        }
        .toast.show { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>
    <div class="toast-stack" id="toast-stack">
        @if (session('status'))
            <div class="toast show">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="toast show" style="border-color: rgba(255,123,123,0.6);">{{ $errors->first() }}</div>
        @endif
    </div>
    <div class="shell">
        <div class="glow"></div>
        <header>
            <div>
                <h1>Profile & Settings</h1>
                <div style="color: var(--muted);">Manage your name and account.</div>
            </div>
            <a href="/">← Back to dashboard</a>
        </header>

        <div class="card">
            <strong>Profile</strong>
            <form method="POST" action="/settings" enctype="multipart/form-data">
                @csrf
                <div class="row" style="align-items:center;">
                    <img class="avatar" src="{{ $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : 'https://api.dicebear.com/7.x/identicon/svg?seed='.urlencode($user->email) }}" alt="Avatar">
                    <div style="flex:1; display:grid; gap:10px;">
                        <label for="avatar">Profile picture</label>
                        <input id="avatar" type="file" name="avatar" accept="image/*">
                    </div>
                </div>
                <div>
                    <label for="name">Display name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div>
                    <label for="email">Email (read-only for now)</label>
                    <input id="email" type="email" value="{{ $user->email }}" disabled>
                </div>
                <div class="row">
                    <button class="button" type="submit">Save changes</button>
                    <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </form>
        </div>

        <div class="card" style="margin-top:18px;">
            <strong>Change password</strong>
            <form method="POST" action="/settings/password">
                @csrf
                <div>
                    <label for="current_password">Current password</label>
                    <input id="current_password" type="password" name="current_password" required>
                </div>
                <div>
                    <label for="password">New password</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <div>
                    <label for="password_confirmation">Confirm new password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
                <div class="row">
                    <button class="button" type="submit">Update password</button>
                </div>
            </form>
        </div>

        <form id="logout-form" method="POST" action="/logout" style="display:none;">@csrf</form>
    </div>

    <script>
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach((toast) => {
            setTimeout(() => toast.classList.add('show'), 50);
            setTimeout(() => toast.classList.remove('show'), 3200);
        });
    </script>
</body>
</html>
