<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Reservasi Podcast</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #87CEEB; /* Biru langit */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background-color: #ffffff; /* Putih */
            padding: 30px;
            width: 340px;
            border: 1px solid #b0d4e3;
            border-radius: 6px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0 0 5px 0;
            color: #222222;
            font-size: 22px;
        }
        .header p {
            margin: 0;
            color: #555555;
            font-size: 13px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333333;
            font-weight: bold;
        }
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 9px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #38bdf8;
        }
        .remember {
            margin-bottom: 15px;
            font-size: 13px;
            color: #444444;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #38bdf8; /* Biru langit tombol */
            border: none;
            border-radius: 4px;
            color: #ffffff;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #0284c7;
        }
        .error-box {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 8px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .info-akun {
            margin-top: 20px;
            padding-top: 12px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #555555;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="header">
        <h2>Selamat Datang</h2>
        <p>Masuk untuk reservasi studio podcast</p>
    </div>

    @if ($errors->any())
        <div class="error-box">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>

        <div class="remember">
            <label>
                <input type="checkbox" name="remember"> Ingat saya
            </label>
        </div>

        <button type="submit" class="btn-submit">Masuk</button>
    </form>

</div>

</body>
</html>