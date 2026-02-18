<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password · To-Do HQ</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Space Grotesk',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0b1021;color:#e7ecff;display:grid;place-items:center;padding:28px}
        .card{width:min(520px,100%);background:rgba(17,25,52,0.78);border-radius:22px;padding:26px}
        label{font-size:13px;color:#9db0d9}
        input{width:100%;padding:12px;border-radius:12px;border:1px solid rgba(255,255,255,0.06);background:rgba(255,255,255,0.03);color:inherit}
        .button{margin-top:8px;padding:12px;border-radius:12px;border:none;background:linear-gradient(135deg,#7cf3c2,#5bc8ff);color:#031017;font-weight:700}
        .error{background:rgba(255,156,156,0.08);padding:10px;border-radius:10px;color:#ff9c9c}
        a{color:#7cf3c2}
    </style>
</head>
<body>
    <div class="card">
        <h1>Reset password</h1>
        <p>Set a new password for your account.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/reset-password">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $email ?? '') }}" required autofocus>
            </div>

            <div>
                <label for="password">New password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <button class="button" type="submit">Reset password</button>
        </form>

        <p style="margin-top:12px"><a href="/login">Back to sign in</a></p>
    </div>
</body>
</html>
