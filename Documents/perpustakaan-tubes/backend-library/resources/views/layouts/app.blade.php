<!DOCTYPE html>
<html>
<head>
    <title>Library App</title>
</head>
<body>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a> |
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button>Logout</button>
        </form>
    </nav>

    <main style="padding:20px">
        {{ $slot }}
    </main>
</body>
</html>
