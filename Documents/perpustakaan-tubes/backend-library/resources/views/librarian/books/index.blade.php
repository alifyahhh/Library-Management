<x-app-layout :header="__('Manage Books')">
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

    <form method="GET" action="{{ route('librarian.books.index') }}">
        <input name="keyword" placeholder="search..." value="{{ request('keyword') }}">
        <button>Search</button>
    </form>

    <p><a href="{{ route('librarian.books.create') }}">+ Create Book</a></p>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr><th>Title</th><th>Category</th><th>Stock</th><th>Action</th></tr>
        @foreach($books as $b)
            <tr>
                <td>{{ $b->title }}</td>
                <td>{{ $b->category?->name }}</td>
                <td>{{ $b->stock }}</td>
                <td>
                    <a href="{{ route('librarian.books.edit',$b) }}">Edit</a>
                    <form method="POST" action="{{ route('librarian.books.destroy',$b) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div style="margin-top:12px;">{{ $books->links() }}</div>
</x-app-layout>
