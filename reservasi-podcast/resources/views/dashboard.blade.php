<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Dashboard</title></head>
<body style="font-family: sans-serif; padding: 40px;">
    <h1>Halo, {{ auth()->user()->name }} 👋</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
