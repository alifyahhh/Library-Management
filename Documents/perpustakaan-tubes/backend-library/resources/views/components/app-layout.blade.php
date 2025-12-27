@props(['header' => null])

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Library Admin</title>
</head>
<body>
    <nav style="padding:12px;border-bottom:1px solid #ddd;">
        <a href="{{ route('dashboard') }}">Dashboard</a>

        @auth
            @if(auth()->user()->role === 'librarian')
                | <a href="{{ route('librarian.dashboard') }}">Librarian</a>
                | <a href="{{ route('librarian.books.index') }}">Books</a>
                | <a href="{{ route('librarian.categories.index') }}">Categories</a>
                | <a href="{{ route('librarian.borrowings.index') }}">Borrowings</a>
                | <a href="{{ route('librarian.fines.index') }}">Fines</a>
            @endif

            <form method="POST" action="{{ route('logout') }}" style="display:inline;margin-left:12px;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endauth
    </nav>

    @if($header)
        <header style="padding:16px;border-bottom:1px solid #eee;">
            {{ $header }}
        </header>
    @endif

    <main style="padding:16px;">
        {{ $slot }}
    </main>
</body>
</html>
