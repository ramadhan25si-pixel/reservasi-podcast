<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Reservasi Podcast</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #4f46e5, #7c3aed 50%, #ec4899);
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 16px;
            padding: 40px 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
        }

        .logo {
            width: 56px; height: 56px;
            margin: 0 auto 16px;
            border-radius: 14px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
        }

        h1 { text-align: center; font-size: 24px; color: #111827; }
        .subtitle { text-align: center; color: #6b7280; font-size: 14px; margin: 6px 0 28px; }

        .field { margin-bottom: 18px; }
        label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 6px; }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color .2s, box-shadow .2s;
        }
        input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .15);
        }
        input.invalid { border-color: #ef4444; }

        .error { color: #dc2626; font-size: 13px; margin-top: 6px; }

        .row {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 14px; color: #4b5563; margin-bottom: 22px;
        }
        .row label { display: flex; align-items: center; gap: 6px; font-weight: 400; margin: 0; cursor: pointer; }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }
        button:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(79, 70, 229, .4); }
        button:active { transform: translateY(0); }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">🎙️</div>
        <h1>Selamat Datang</h1>
        <p class="subtitle">Masuk untuk reservasi studio podcast</p>

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       class="{{ $errors->has('email') ? 'invalid' : '' }}"
                       required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       placeholder="••••••••"
                       class="{{ $errors->has('password') ? 'invalid' : '' }}"
                       required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <label><input type="checkbox" name="remember"> Ingat saya</label>
            </div>

            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>
